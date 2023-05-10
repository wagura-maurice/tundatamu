<?php

namespace App\Repositories\Mpesa;

use App\Traits\LNMOTrait;
use App\Models\Transaction;
use Illuminate\Support\Facades\URL;
use App\Interfaces\Mpesa\LNMOInterface;

class LNMORepository implements LNMOInterface
{
    use LNMOTrait;

    /*********************************************************************
     *
     * LNMO APIs
     * 
     * Resources: https://peternjeru.co.ke/safdaraja/ui/#lnm_tutorial
     * 
     * *******************************************************************/
    /**
     * LNMO request
     *
     * This method is used to initiate online transaction on behalf of a customer.
     *
     * @param array $data from mpesa api
     * @return Json response for transaction details i.e transaction code and timestamps e.t.c
     */
    public function transact(array $data)
    {
        try {
            // transactions endpoint provided by service provider.
            $endpoint = 'https://' . getSetting('MPESA_LNMO_ENVIRONMENT') . '.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

            // data to be sent for processing.
            $data = array_merge($data, array_filter([
                'BusinessShortCode' => getSetting('MPESA_LNMO_SHORT_CODE'),
                'Password' => base64_encode(getSetting('MPESA_LNMO_SHORT_CODE') . getSetting('MPESA_LNMO_PASS_KEY') . $this->timestamp),
                'Timestamp' => $this->timestamp,
                'TransactionType' => Transaction::CUSTOMER_PAY_BILL_ONLINE, // ['CustomerPayBillOnline', 'CustomerBuyGoodsOnline]
                'PartyB' => getSetting('MPESA_LNMO_TILL_NUMBER'),
                'CallBackURL' => secure_url(URL::route('mpesa.lnmo.callback', [], false))
            ]));
            
            // send data for processing
            $response = $this->submit($endpoint, $data);

            // save transaction details if response is valid
            if (isset($response->ResponseCode) && $response->ResponseCode == 0) {
                // create transaction data.
                $transaction = new Transaction;
                $transaction->_pid = generatePID(Transaction::class, 10);
                $transaction->party_a = $data['PhoneNumber'];
                $transaction->party_b = getSetting('MPESA_LNMO_TILL_NUMBER');
                $transaction->account_reference = $data['AccountReference'];
                $transaction->transaction_category = Transaction::PURCHASE;
                $transaction->transaction_type = Transaction::CREDIT;
                $transaction->transaction_channel = Transaction::LNMO;
                $transaction->transaction_aggregator = Transaction::MPESA_KE;
                $transaction->transaction_id = $response->CheckoutRequestID;
                $transaction->transaction_amount = $data['Amount'];
                $transaction->transaction_code = null;
                $transaction->transaction_timestamp = $this->timestamp;
                $transaction->transaction_details = $data['TransactionDesc'];
                $transaction->_feedback = collect([
                    $this->timestamp => [
                        'transact' => (array) $response,
                    ],
                ])->toJson();
                $transaction->_status = Transaction::PROCESSING;
                $transaction->save();
            }

            return $response;

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description . ': \n' . 'error message: ' . $th->getMessage());
        }
    }

    /**
     * LNMO query
     *
     * This method is used to check the status of a Lipa Na M-Pesa Online Transaction.
     *
     * @param string $identifier from mpesa api
     * @return Json response for transaction details i.e transaction code and timestamps e.t.c
     */
    public function query(string $identifier)
    {
        try {
            /* Fetching a transaction record from the database using the transaction id as the unique identifier. */
            $transaction = Transaction::where('transaction_id', $identifier)->first();

            if(optional($transaction)->id) {
                // transactions endpoint provided by service provider.
                $endpoint = 'https://' . getSetting('MPESA_LNMO_ENVIRONMENT') . '.safaricom.co.ke/mpesa/stkpushquery/v1/query';

                // data to be sent for processing.
                $data = array_filter([
                    'BusinessShortCode' => getSetting('MPESA_LNMO_SHORT_CODE'),
                    'Password' => base64_encode(getSetting('MPESA_LNMO_SHORT_CODE') . getSetting('MPESA_LNMO_PASS_KEY') . $this->timestamp),
                    'Timestamp' => $this->timestamp,
                    'CheckoutRequestID' => $identifier
                ]);

                // send data for processing
                $response = $this->submit($endpoint, $data);

                // update transaction
                if(isset($response->ResultCode) && $response->ResultCode == 0) {
                    // update transaction status to accepted.
                    $transaction->_feedback = collect(array_merge(json_decode($transaction->_feedback, true), ['query' => $data]))->toJson();
                    $transaction->_status = Transaction::ACCEPTED;
                    $transaction->save();
                    
                    // publish transaction accepted notification, to partyA. preferably via a text messaging service.
                } else {
                    // update transaction status to rejected.
                    $transaction->_feedback = collect(array_merge(json_decode($transaction->_feedback, true), ['query' => $data]))->toJson();
                    $transaction->_status = Transaction::REJECTED;
                    $transaction->save();

                    // publish transaction rejected notification, to partyA. preferably via a text messaging service.
                }

                return $response;
            }
            
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description . ': \n' . 'error message: ' . $th->getMessage());
        }
    }

    /**
     * LNMO callback
     *
     * This method is used to confirm a LNMO Transaction that has passed various methods set by the developer during validation
     *
     * @param array $data from mpesa api
     * @return Json respond for transaction details i.e transaction code and timestamps e.t.c
     */
    public function callback(array $request)
    {
        try {
            // load callback response
            $callback = $request['Body']['stkCallback'];

            // find transaction via CheckoutRequestID as the unique transaction Id.
            $transaction = Transaction::where('transaction_id', $callback['CheckoutRequestID'])->first();

            if($transaction) {
                // update transaction.
                if(isset($callback['ResultCode']) && $callback['ResultCode'] === 0 && optional($callback['CallbackMetadata'])['Item'][1]['Value']) {
                    // update transaction status to accepted.
                    $transaction->transaction_code = $callback['CallbackMetadata']['Item'][1]['Value'];
                    $transaction->_feedback = collect(array_merge(json_decode($transaction->_feedback, true), [
                        $this->timestamp => [
                            'callback' => (array) $request
                        ]
                    ]))->toJson();
                    $transaction->_status = Transaction::ACCEPTED;
                    $transaction->save();

                    // publish transaction accepted notification, to partyA.
                } else {
                    // update transaction status to rejected.
                    $transaction->_feedback = collect(array_merge(json_decode($transaction->_feedback, true), [
                        $this->timestamp => [
                            'callback' => (array) $request
                        ]
                        ]))->toJson();
                    $transaction->_status = Transaction::REJECTED;
                    $transaction->save();

                    // publish transaction rejected notification, to partyA.
                }
            }

            return $callback;

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description . ': \n' . 'error message: ' . $th->getMessage());
        }
    }
}