<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class YearOfBirth extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('yearOfBirth') ? __('Input entered is not valid! Please enter year of birth to continue.') : __('Please enter year of birth to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('yearOfBirth', trim($argument));

        $this->decision->custom(function ($input) {
            return is_string(trim($input)) && !empty(trim($input)) /* && isValidYear($input) */ ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Gender::class)->any(self::class);
    }
}
