<?php

namespace App\Http\Ussd\States\Sell\Product;

use Sparors\Ussd\State;

class Metric extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('quantity') ? __('Sorry, that answer was not valid. How many kilograms of ' . ucwords($this->record->get('variety')) . ' are you selling? (e.g. 0.5)') : __('How many kilograms of ' . ucwords($this->record->get('variety')) . ' are you selling? (e.g. 0.5)'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('quantity', trim($argument));

        $this->decision->numeric(\App\Http\Ussd\States\Sell\Product\Confirmation::class)
            ->any(self::class);
    }
}
