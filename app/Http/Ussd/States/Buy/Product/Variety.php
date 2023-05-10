<?php

namespace App\Http\Ussd\States\Buy\Product;

use Sparors\Ussd\State;

class Variety extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('variety') ? __('Sorry, that answer was not valid. Select ' . $this->record->get('category') . ' variety to continue') :  __('Select ' . $this->record->get('category') . ' variety to continue'))
            ->lineBreak(1)
            ->listing(array_values(array_filter($this->record->get('category') == 'seedlings' ? [
                __('KP4'),
                __('Back')
            ] : [
                __('D.A.P'),
                __('C.A.N'),
                __('N.P.K'),
                __('Back')
            ])));
    }

    protected function afterRendering(string $argument): void
    {
        if($this->record->get('category') == 'seedlings') {
            if ($argument != '2') {
                $this->record->set('variety', 'kp4');
            }

            $this->decision
                ->equal('1', \App\Http\Ussd\States\Buy\Product\Metric::class)
                ->equal('2', \App\Http\Ussd\States\Initialize::class)
                ->any(self::class);
        }

        if($this->record->get('category') == 'fertilizer') {
            if ($argument != '4') {
                if ($argument == '1') {
                    $this->record->set('variety', 'dap');
                } elseif ($argument == '2') {
                    $this->record->set('variety', 'can');
                } elseif ($argument == '3') {
                    $this->record->set('variety', 'npk');
                }
            }

            $this->decision
                ->between(1, 3, \App\Http\Ussd\States\Buy\Product\Metric::class)
                ->equal('4', \App\Http\Ussd\States\Initialize::class)
                ->any(self::class);
        }
    }
}
