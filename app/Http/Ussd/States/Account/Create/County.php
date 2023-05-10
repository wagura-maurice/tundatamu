<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class County extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('county') ? __('Input entered is not valid! Please enter your county name or code to continue.') : __('Please enter your county name or code to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        $county = getCounty(trim($argument));

        if (optional($county)->id) {
            $this->record->set('county', strtolower($county->name));
            $this->record->set('county_number', strtolower($county->code));
        }
        
        $this->decision->custom(function ($input) {
            return is_string(trim($input)) && !empty(trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Location::class)->any(self::class);
    }
}
