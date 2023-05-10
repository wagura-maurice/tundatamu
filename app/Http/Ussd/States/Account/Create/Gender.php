<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Gender extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('gender') ? __('Input entered is not valid! Please enter your gender to continue.') : __('Please enter your gender to continue.'))
            ->lineBreak(1)
            ->listing(array_values([
                __('Male'),
                __('Female')
            ]));
    }

    protected function afterRendering(string $argument): void
    {
        if (trim($argument) == '1') {
            $this->record->set('gender', 'male');
        } else {
            $this->record->set('gender', 'female');
        }

        $this->decision
            ->between(1, 2, \App\Http\Ussd\States\Account\Create\County::class)
            ->any(self::class);
    }
}
