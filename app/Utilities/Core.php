<?php

use App\Models\County;

if (! function_exists('getCounty')) {
    /**
     * It returns a county object from the database
     * 
     * @param string data The data to be searched for.
     * @param string method The method name where the error occurred.
     * 
     * @return object A county object
     */
    function getCounty(string $data, string $method = NULL): object
    {
        try {
            if(is_numeric($data)) {
                $county = County::where('code', (int) ltrim($data, "0"))
                    ->first();
            } else {
                $county = County::where('name', 'LIKE', '%' . strtolower($data) . '%')
                    // ->OrWhere('headquarter', 'LIKE', '%' . strtolower($data) . '%')
                    // ->OrWhere('abbreviation', 'LIKE', '%' . strtolower($data) . '%')
                    ->first();
            }

            return $county;

        } catch (\Throwable $th) {
            throw $th;
            // eThrowable($method, $th->getMessage());
        }
    }
}

