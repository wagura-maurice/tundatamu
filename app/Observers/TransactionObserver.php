<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        try {
            // 
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        try {
            if($transaction->wasChanged('transaction_code') && $transaction->wasChanged('_status')) {
                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://tundatamu.co.ke/marketplace/checkout/orders/mpesa-webhook/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode([
                        'date' => Carbon::parse($transaction->transaction_timestamp)->toDateTimeString(),
                        'amount' => (int) $transaction->transaction_amount,
                        'transaction_code' => $transaction->transaction_code,
                        'order_id' => $transaction->account_reference
                    ]),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json'
                    ]
                ]);

                $error    = curl_error($curl);
                $response = json_decode(curl_exec($curl));

                curl_close($curl);

                /* if ($error) {
                    Log::info('Oops! server error encountered, please try again!');
                } else {
                    Log::info('Oops! Order NOT successfully updated, please try again!');
                    Log::info(print_r($response->all(), true));

                    dd($response->all());
                } */
            }
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
