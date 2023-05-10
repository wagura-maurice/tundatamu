<?php

namespace App\Http\Ussd\Actions\Buy\Product;

use Sparors\Ussd\Action;

class Order extends Action
{
    public function run(): string
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://tundatamu.co.ke/api/buy/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    'phone_number' => substr($this->record->get('phoneNumber'), -9),
                    'product_name' => NULL,
                    'category' => NULL,
                    'seedling_type' => $this->record->get('category') == 'seedlings' ? $this->record->get('variety') : NULL,
                    'fertilizer_type' => $this->record->get('category') == 'fertilizer' ? $this->record->get('variety') : NULL,
                    'metric' => (int) $this->record->get('quantity')
                ]),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json'
                ]
            ]);

            $error    = curl_error($curl);
            $response = json_decode(curl_exec($curl));

            curl_close($curl);

            if ($error) {
                $this->record->set('prompt', __('Oops! server error encountered, please try again!'));
            } else {
                if (optional($response)->id) {
                    $this->record->set('prompt', __('Congratulations! Order ' . strtoupper($response->id) . ' was successfully created.'));
                } else {
                    $this->record->set('prompt', __('Oops! Order NOT successfully created, please try again!'));
                }
            }
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }

        return \App\Http\Ussd\States\Terminate::class; // The state after this
    }
}
