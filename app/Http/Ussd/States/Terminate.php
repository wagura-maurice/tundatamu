<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;

class Terminate extends State
{
    protected function beforeRendering(): void
    {
        if($this->record->prompt) {
            $this->menu->text(__($this->record->prompt . ' for enquires? Call ' . getSetting('CUSTOMER_CARE_CALLER_ID')));
        } else {
            $this->menu->text(__('thank you for using ' . config('app.name') . ' services, for enquires? Call ' . getSetting('CUSTOMER_CARE_CALLER_ID')));
        }
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->deleteMultiple([
            'sessionId',
            'phoneNumber',
            'networkCode',
            'network'
        ]);
    }
}
