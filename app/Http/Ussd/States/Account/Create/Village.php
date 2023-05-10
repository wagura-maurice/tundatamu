<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Village extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('village') ? __('Input entered is not valid! Please enter your village to continue.') : __('Please enter your village to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('village', strtolower(trim($argument)));

        $this->decision->custom(function ($input) {
            return is_string(trim($input)) && !empty(trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Landmark::class)->any(self::class);
    }
}
