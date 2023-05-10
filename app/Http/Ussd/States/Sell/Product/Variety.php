<?php

namespace App\Http\Ussd\States\Sell\Product;

use Sparors\Ussd\State;

class Variety extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('variety') ? __('Sorry, that answer was not valid. Select yellow passion fruit variety to continue') :  __('Select yellow passion fruit variety to continue'))
            ->lineBreak(1)
            ->listing(array_values(array_filter([
                __('Grade 1'),
                __('Grade 2'),
                __('Grade 3'),
                __('Back')
            ])));
    }

    protected function afterRendering(string $argument): void
    {
            if ($argument != '4') {
                if ($argument == '1') {
                    $this->record->set('variety', 'grade1');
                } elseif ($argument == '2') {
                    $this->record->set('variety', 'grade2');
                } elseif ($argument == '3') {
                    $this->record->set('variety', 'grade3');
                }
            }

            $this->decision
            ->between(1, 3, \App\Http\Ussd\States\Sell\Product\Metric::class)
                ->equal('4', \App\Http\Ussd\States\Initialize::class)
                ->any(self::class);
    }
}
