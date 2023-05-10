<?php

namespace App\Http\Ussd\States;

use Sparors\Ussd\State;
use Illuminate\Support\Facades\Cache;

class Initialize extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text(__(ucwords(greetings() . ' ' . Cache::get($this->record->get('phoneNumber'))->user->first_name . ', welcome to ' . config('app.name') . '. for enquires? Call ' . getSetting('CUSTOMER_CARE_CALLER_ID'))))
            ->lineBreak(1)
            ->text(__('Select action to continue'))
            ->lineBreak(1)
            ->listing(array_values(array_filter([
                __('Buy'),
                __('Sell'),
                __('Exit')
            ])));
    }

    protected function afterRendering(string $argument): void
    {
        $this->decision
            ->equal('1', \App\Http\Ussd\States\Buy\Product\Category::class)
            ->equal('2', \App\Http\Ussd\States\Sell\Product\Variety::class)
            ->equal('3', \App\Http\Ussd\States\Terminate::class)
            ->any(self::class);
    }
}
