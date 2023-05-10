<?php

namespace App\Http\Ussd\States\Buy\Product;

use Sparors\Ussd\State;

class Category extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('category') ? __('Sorry, that answer was not valid. Select product category to continue') :  __('Select product category to continue'))
            ->lineBreak(1)
            ->listing(array_values(array_filter([
                __('Seedlings'),
                __('Fertilizer'),
                __('Back')
            ])));
    }

    protected function afterRendering(string $argument): void
    {
        if ($argument != '3') {
            $this->record->set('category', $argument == '1' ? 'seedlings' : 'fertilizer');
        }

        $this->decision
            ->between(1, 2, \App\Http\Ussd\States\Buy\Product\Variety::class)
            ->equal('3', \App\Http\Ussd\States\Initialize::class)
            ->any(self::class);
    }
}
