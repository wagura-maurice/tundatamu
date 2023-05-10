<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

trait LNMOTrait
{
    /**
     * Provide for description of repository
     * @var string $timestamps
     */
    private $description;
    
    /**
     * Provide for timestamp of transactions
     * @var string $timestamp
     */
    private $timestamp;

    /**
     * Construct method
     *
     * Initializes the class with an array of API values.
     *
     * @return void
     * @throws exception if the values array is not valid
     */
    public function __construct()
    {
        /* A description of the repository. */
        $this->description = 'lipa na mpesa online daraja api repository pattern.';

        /* Setting the timestamp to the current date and time. */
        $this->timestamp = Carbon::now()->format('YmdHis');
    }

    /**
     * > If the cache doesn't have an access token, generate one and cache it for 59 minutes. If it
     * does, return the cached access token
     * 
     * @return The access token is being returned.
     */
    private function fetchAccessToken()
    {
        try {
            if (!Cache::has('ACCESS_TOKEN')) {
                return Cache::remember('ACCESS_TOKEN', now()->addMinutes(59), function () {
                    return $this->generateAccessToken();
                });
            }

            return Cache::get('ACCESS_TOKEN');
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description . ': \n' . 'error message: ' . $th->getMessage());
        }
    }

    /**
     * It generates an access token for the LNMO API
     * 
     * @return The access token is being returned.
     */
    private function generateAccessToken()
    {
        try {
            $endpoint = 'https://' . getSetting('MPESA_LNMO_ENVIRONMENT') . '.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $response = Http::acceptJson()
                ->withToken(base64_encode(getSetting('MPESA_LNMO_CONSUMER_KEY') . ':' . getSetting('MPESA_LNMO_CONSUMER_SECRET')), 'Basic')
                ->get($endpoint);

            return optional($response->object())->access_token;

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description . ': \n' . 'error message: ' . $th->getMessage());
        }
    }

    /**
     * It takes a url and an array of data, and returns the response object
     * 
     * @param string url The url to submit the data to.
     * @param array data The data to be sent to the API.
     * 
     * @return The response object is being returned.
     */
    private function submit(string $url, array $data)
    {
        try {
            if ($this->fetchAccessToken() != '' || $this->fetchAccessToken() !== false) {
                $response = Http::acceptJson()
                    ->withToken($this->fetchAccessToken())
                    ->post($url, $data);

                return $response->object();
            }
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description . ': \n' . 'error message: ' . $th->getMessage());
        }
    }
}
