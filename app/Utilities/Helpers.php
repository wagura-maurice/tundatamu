<?php

use App\Models\Setting;
use App\Models\LightOfGuidance;
use libphonenumber\PhoneNumberUtil;
use Illuminate\Support\Facades\Cache;
use libphonenumber\PhoneNumberFormat;

if (! function_exists('eThrowable')) {
    /**
     * > It creates a new instance of the `LightOfGuidance` model and saves it to the database
     * 
     * @param string _class The name of the class that the error is coming from.
     * @param string description The description of the error.
     * 
     * @return object The newly created object.
     */
    function eThrowable(string $_class, string $description): object
    {
        $LOG = new LightOfGuidance;
        $LOG->_class = $_class;
        $LOG->description = strtoupper($description);
        $LOG->save();

        return $LOG->fresh();
    }
}

if (! function_exists('updateSetting')) {
    /**
     * "Update a setting in the database."
     * 
     * The function is named `updateSetting` and it takes two parameters: `` and ``. The
     * `` parameter is a string and the `` parameter is a string. The function returns an
     * object
     * 
     * @param string item The name of the setting you want to update.
     * @param string data The data to be saved.
     * 
     * @return object The updated setting.
     */
    function updateSetting(string $item, string $data): object
    {
        $setting = Setting::whereItem($item)->first();
        $setting->current_value = trim($data);
        $setting->save();

        return $setting->fresh();
    }
}

if (! function_exists('getSetting')) {
    /**
     * "Get the current value of a setting, or the default value if the current value is not set."
     * 
     * The function is pretty simple. It takes a string as an argument, and returns a string. The
     * string is the value of the setting
     * 
     * @param string item The name of the setting you want to get.
     * 
     * @return string The current value of the setting if it exists, otherwise the default value.
     */
    function getSetting(string $item): string
    {
        $setting = Setting::whereItem($item)->first();

        return optional($setting)->current_value ?? $setting->default_value;
    }
}

if (! function_exists('generatePID')) {
    /**
     * It generates a unique product ID for a given model
     * 
     * @param model The model you want to generate the PID for.
     * @param length The length of the generated PID.
     * 
     * @return string A function that returns a string.
     */
    function generatePID($model, $length = 5): string
    {
        $latest = $model::latest()->first();
        
        $_PID = str_pad(optional($latest)->id + 1, $length, "0", STR_PAD_LEFT);

        return strtoupper($_PID);
    };
}

if (! function_exists('generateUUID')) {
    /**
     * It generates a random number, then formats it as a UUID
     * 
     * @return string A UUID
     */
    function generateUUID(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),

            // 16 bits for "time_mid"
            mt_rand(0, 0xFFFF),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0FFF) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3FFF) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
        );
    }
}

if (! function_exists('excelDateToPhpDate')) {
    /**
     * It converts an excel date to a php date.
     * 
     * @param string date The date in Excel format.
     * 
     * @return datetime A datetime object
     */
    /* function excelDateToPhpDate(string $date): datetime
    {
        return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(trim($date));
    } */
}

if (! function_exists('greetings')) {
    /**
     * It returns a greeting based on the current time
     * 
     * @return string A string.
     */
    function greetings(): string
    {
        $hour = date('H');

        if ($hour >= 18) {
            $greeting = 'Good evening';
        } elseif ($hour >= 12) {
            $greeting = 'Good afternoon';
        } elseif ($hour < 12) {
            $greeting = 'Good morning';
        }

        return __($greeting);
    }
}

if (! function_exists('isValidYear')) {
    /**
     * It checks if the year is between 75 years back and 18 years back
     * 
     * @param year The year of birth.
     */
    function isValidYear($year)
    {
        $start_year    = strtotime(date('Y') - 75); // 75 Years back
        $end_year      = strtotime(date('Y') - 18); // 18 Years back
        $received_year = strtotime($year);

        return (($received_year >= $start_year) && ($received_year <= $end_year));
    }
}

if (! function_exists('phoneNumberPrefix')) {
    /**
     * It takes a phone number, a country code and a length and returns a formatted phone number
     * 
     * @param string phone_number The phone number to be formatted
     * @param string code The country code. Default is Kenya.
     * @param int length The length of the phone number to be returned.
     * 
     * @return string the phone number in the E164 format.
     */
    function phoneNumberPrefix(string $phone_number, string $code = 'KE', int $length = -9): string
    {
        $number = substr($phone_number, $length);
        $phoneUtil = PhoneNumberUtil::getInstance();

        return $phoneUtil->format($phoneUtil->parse($number, $code), PhoneNumberFormat::E164);
    }
}

if (! function_exists('substrReplace')) {
    /**
     * `substr_replace(, '...', )`
     * 
     * @param string string The string to be truncated.
     * @param int length The maximum length of the string.
     * 
     * @return string ```
     *  = '1';
     *  = &;
     *  = "2";
     * echo .", ".;
     * ```
     */
    function substrReplace(string $string, int $length): string
    {
        return  substr_replace($string, '...', $length);
    }
}

if (! function_exists('arrayKeyWalk')) {
    /**
     * It takes an array and an array of key replacements, and returns the array with the keys replaced
     * 
     * @param array item The array to be walked
     * @param array keyReplacements An array of key replacements. The key is the old key, the value is
     * the new key.
     * 
     * @return array The array with the keys replaced.
     */
    function arrayKeyWalk(array $item, array $keyReplacements): array
    {
        array_walk($item, function ($value, $key) use ($keyReplacements, &$item) {
            $newkey = array_key_exists($key, $keyReplacements) ? $keyReplacements[$key] : false;
            if ($newkey !== false) {
                $item[$newkey] = $value;
                unset($item[$key]);
            }
        });

        return $item;
    }
}

if (! function_exists('getOnlyNumbers')) {
    /**
     * It takes a string, removes all non-numeric characters, and returns the result
     * 
     * @param alphaNumeric The string you want to remove all non-numeric characters from.
     * 
     * @return string a string.
     */
    function getOnlyNumbers($alphaNumeric): string
    {
        return preg_replace("/[^-0-9\.]/", '', $alphaNumeric);
    }
}

if (! function_exists('getOnlyAlphabets')) {
    /**
     * It takes a string and returns only the alphabets in it
     * 
     * @param alphaNumeric The string to be filtered.
     * 
     * @return string a string.
     */
    function getOnlyAlphabets($alphaNumeric): string
    {
        return preg_replace("/[^-_aA-zZ\.]/", '', $alphaNumeric);
    }
}

if (! function_exists('getPercentOfNumber')) {
    /**
     * Get the percentage of a number.
     * 
     * @param percent The percentage you want to get from the number.
     * @param number The number you want to get the percentage of.
     * 
     * @return int The absolute value of the percentage of the number.
     */
    function getPercentOfNumber($percent, $number): int
    {
        return abs(($percent / 100) * $number);
    }
}

if (! function_exists('submit')) {
    /**
     * Submit Request
     *
     * Handles submission of all API endpoints queries
     *
     * @param string $url The API endpoint URL
     * @param string $protocol The HTTP Protocol the endpoint $url
     * @param array $fields The data to send to the endpoint $url
     * @param array $header The request headers for processing the endpoint $url
     * @param string $method The class of the application initiating this request
     * @return object|boolean Curl response or false on failure
     * @throws exception if the requirements are not valid
     */
    function submit(string $url, string $protocol, array $fields = [], array $header, string $method)
    {
        try {
            
            $curl = curl_init();

            if ($protocol == 'POST') {
                $payload =  [
                    CURLOPT_URL            => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 30000,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => 'POST',
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => json_encode($fields),
                    CURLOPT_HTTPHEADER     => $header
                ];
            } elseif ($protocol == 'GET') {
                $payload = [
                    CURLOPT_URL            => $fields ? $url . "?" . http_build_query($fields) : $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_TIMEOUT        => 30000,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => 'GET',
                    CURLOPT_HTTPHEADER     => $header
                ];
            }

            curl_setopt_array($curl, $payload);

            $error    = curl_error($curl);
            $response = curl_exec($curl);

            curl_close($curl);

            return $error ? $error : json_decode($response);

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable($method, $th->getMessage());
        }
    }
}
