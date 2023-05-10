<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Organization extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('organization') ? __('Input entered is not valid! Please enter your farmer group/co-operative code, else enter 0 to continue.') : __('Please enter your farmer group/co-operative code, else enter 0 to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        if ($argument != '0') {
            $this->record->set('organization', strtoupper(trim($argument)));
        }

        $this->decision->custom(function ($input) {
            return empty($input) ? true : (preg_match('/^[a-zA-Z0-9]{5}/', trim($input)) ? true : false);
        }, \App\Http\Ussd\States\Account\Create\Enumerator::class)->any(self::class);
    }
}
