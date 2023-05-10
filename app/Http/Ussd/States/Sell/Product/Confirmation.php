<?php

namespace App\Http\Ussd\States\Sell\Product;

use Sparors\Ussd\State;

class Confirmation extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text(__('DETAILS CONFIRMATION:'))
            ->lineBreak(1)
            ->text('VARIETY: ' . ucwords($this->record->get('variety')))
            ->lineBreak(1)
            ->text('KG: ' . $this->record->get('quantity'))
            ->lineBreak(1)
            ->listing([
                __('Continue'),
                __('Cancel')
            ]);
    }

    protected function afterRendering(string $argument): void
    {
        $this->decision
            ->equal('1', \App\Http\Ussd\Actions\Sell\Product\Order::class)
            ->equal('2', \App\Http\Ussd\States\Terminate::class)
            ->any(self::class);
    }
}
