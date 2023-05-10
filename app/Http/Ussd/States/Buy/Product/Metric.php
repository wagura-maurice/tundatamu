<?php

namespace App\Http\Ussd\States\Buy\Product;

use Sparors\Ussd\State;

class Metric extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('quantity') ? __('Sorry, that answer was not valid. How many kilograms of ' . ucwords($this->record->get('variety')) . ' do you what? (e.g. 0.5)') : __('How many kilograms of ' . ucwords($this->record->get('variety')) . ' do you what? (e.g. 0.5)'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('quantity', trim($argument));

        $this->decision->numeric(\App\Http\Ussd\States\Buy\Product\Confirmation::class)
            ->any(self::class);
    }
}
