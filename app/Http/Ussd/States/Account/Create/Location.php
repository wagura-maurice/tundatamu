<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Location extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('location') ? __('Input entered is not valid! Please enter your nearest town to continue.') : __('Please enter your nearest town to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('location', strtolower(trim($argument)));

        $this->decision->custom(function ($input) {
            return is_string(trim($input)) && !empty(trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Village::class)->any(self::class);
    }
}
