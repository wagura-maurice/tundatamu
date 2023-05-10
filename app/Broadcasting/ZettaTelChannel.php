<?php

namespace App\Broadcasting;

use App\Models\TextMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

class ZettaTelChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * It sends the message to the ZettaTel API endpoint.
     * 
     * @param notifiable The entity that is receiving the notification.
     * @param Notification notification The notification instance.
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            $message = $notification->toBroadcastingChannel($notifiable);
            // 'apikey' => getSetting('ZETTA_TEL_API_KEY'),
            $response = Http::asForm()->post(getSetting('ZETTA_TEL_MESSAGING_ENDPOINT'), array_filter([
                'userid' => getSetting('ZETTA_TEL_USER_ID'),
                'password' => getSetting('ZETTA_TEL_USER_PASSWORD'),
                'mobile' => $message->getRecipient(),
                'msg' => $message->getContent(),
                'senderid' => getSetting('ZETTA_TEL_SENDER_ID'),
                'msgType' => 'text',
                'duplicatecheck' => true,
                'output' => 'json',
                'sendMethod' => 'quick'
            ]));

            if(optional($response->json())['transactionId'] && $response->json()['statusCode'] == 200) {
                $textMessage = TextMessage::findOrFail($message->getIdentity());
                $textMessage->transaction_id = $response->json()['transactionId'];
                $textMessage->_status = ($response->json()['statusCode'] == 200) ? TextMessage::PROCESSED : TextMessage::PROCESSING;
                $textMessage->save();
            }

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * It sends a POST request to the ZettaTel API endpoint for checking the delivery status of a
     * message and updates the TextMessage with the transaction_amount and _status from the response
     * 
     * @param string unique_id The unique id of the message.
     */
    public function deliveryStatus(string $unique_id)
    {
        // dd((new \App\Broadcasting\ZettaTelChannel)->deliveryStatus('335216523583505456'));

        try {
            $response = Http::asForm()->post(getSetting('ZETTA_TEL_DELIVERY_STATUS_ENDPOINT'), array_filter([
                'userid' => getSetting('ZETTA_TEL_USER_ID'),
                'password' => getSetting('ZETTA_TEL_USER_PASSWORD'),
                'uuid' => $unique_id,
                'output' => 'json'
            ]));

            if(optional($response->json())['response'] && $response->json()['response']['code'] == 200 && optional($response->json()['response'])['report_statusList'][0]['status']) {
                $data = collect($response->json()['response']['report_statusList'][0]['status']);

                $textMessage = TextMessage::where('transaction_id', $unique_id)->first();
                $textMessage->transaction_amount = getOnlyNumbers(optional($data)['cost'] ?? 0);
                $textMessage->_status = ($data['Status'] == 'DELIVERED') ? TextMessage::DELIVERED : TextMessage::FAILED;
                $textMessage->save();
            }

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * It sends a POST request to the ZettaTel API endpoint for checking the account balance and
     * updates the ZETTA_ACCOUNT_BALANCE setting with the smsBalance from the response
     */
    public function accountBalance()
    {
        // dd((new \App\Broadcasting\ZettaTelChannel)->accountBalance());

        try {
            $response = Http::asForm()->post(getSetting('ZETTA_TEL_ACCOUNT_BALANCE_ENDPOINT'), array_filter([
                'userid' => getSetting('ZETTA_TEL_USER_ID'),
                'password' => getSetting('ZETTA_TEL_USER_PASSWORD'),
                'output' => 'json'
            ]));

            if(optional($response->json())['response'] && $response->json()['response']['code'] == 200 && optional($response->json()['response'])['account']) {
                updateSetting('ZETTA_ACCOUNT_BALANCE', optional($response->json())['response']['account']['smsBalance']);
            }

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }
}
