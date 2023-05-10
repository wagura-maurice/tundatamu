<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Name extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text(__(ucwords(greetings() . ', welcome to ' . config('app.name') . '. for enquires? Call ' . getSetting('CUSTOMER_CARE_CALLER_ID'))))
            ->lineBreak(1)
            ->text($this->record->get('name') ? __('Input entered is not valid! Please enter your full name to continue') : __('Please enter your full name to continue'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('name', strtolower(trim($argument)));
        
        $this->decision->custom(function ($input) {
            return is_string(trim($input)) && !empty(trim($input)) && preg_match('/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/', trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\YearOfBirth::class)->any(self::class);
    }
}
