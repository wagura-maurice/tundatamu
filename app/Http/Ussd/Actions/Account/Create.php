<?php

namespace App\Http\Ussd\Actions\Account;

use Sparors\Ussd\Action;
use Illuminate\Support\Facades\Cache;

class Create extends Action
{
    public function run(): string
    {
        try {
            $name = $this->record->get('name') ? optional(explode(' ', $this->record->get('name'))) : NULL;

            $data['user'] = [
                    'first_name' => optional($name)[0] ?? NULL,
                    'last_name' => optional($name)[1] ?? NULL,
                    'username' => substr($this->record->get('phoneNumber'), -9) ?? NULL,
                    'profile' => [
                        'phone_number' => $this->record->get('phoneNumber'),
                        'year_of_birth' => $this->record->get('yearOfBirth') ?? NULL,
                        'gender' => $this->record->get('gender') ?? NULL,
                        'county' => $this->record->get('county_number') ?? NULL
                    ]
            ];

            $data['sub_county'] = $this->record->get('location') ?? NULL;
            $data['county_number'] = $this->record->get('county_number') ?? 2;
            $data['acreage'] = $this->record->get('acreage') ?? NULL;
            $data['enumerator_code'] = $this->record->get('enumerator') ?? NULL;
            $data['selling_place'] = $this->record->get('landmark') ?? NULL;
            $data['farmer_group_code'] = $this->record->get('organization') ?? NULL;
            $data['farmer_number'] = NULL; // explode('-', generateUUID())[0]; // to be removed
            $data['landmark'] = $this->record->get('landmark') ?? NULL;

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://gizpassion.com/api/farmers/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
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
                if (optional($response)->user && $response->user->username == $data['user']['username']) {
                    $this->record->set('prompt', __('Thank you for registering on ' . config('app.name')));

                    /* Sending a text message to the user. */
                    \App\Jobs\TextMessage\Generate::dispatch('onboarding_notification', [
                        'NAME' => strtoupper($data['user']['first_name']),
                        'PHONE_NUMBER' => $data['user']['profile']['phone_number']
                    ]);
                } else {
                    $this->record->set('prompt', __('Oops! Account NOT successfully created, please try again!'));
                }

                Cache::forget($this->record->get('phoneNumber'));
            }
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }

        return \App\Http\Ussd\States\Terminate::class; // The state after this
    }
}
