<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Acreage extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('acreage') ? __('Input entered is not valid! Please enter your land size acreage, else enter 0 to continue.') : __('Please enter your land size acreage, else enter 0 to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        if ($argument != '0') {
            $this->record->set('acreage', trim($argument));
        }

        $this->decision->numeric(\App\Http\Ussd\States\Account\Create\Organization::class)->any(self::class);
    }
}
