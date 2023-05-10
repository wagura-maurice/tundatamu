<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait FlexpayTrait
{
    /**
     * Submit Request
     *
     * Handles submission of all API endpoints queries
     *
     * @param  string  $url The API endpoint URL
     * @param  array  $data The data to POST to the endpoint $url
     * @param  string  $method The API should use
     * @return object|bool Curl response or false on failure
     *
     * @throws Exception if the Access Token is not valid
     */
    protected function submit($url, $data, $method)
    {
        try {
            // Set here required headers
            $header = array_filter([
                'Content-Type: application/x-www-form-urlencoded'
            ]);

            // submit request
            // $request = submit($url, $method, http_build_query($data), $header, get_class($this));
            
            // decode response
            return json_decode($request);

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description.': \n'.'error message: '.$th->getMessage());
        }
    }
}
