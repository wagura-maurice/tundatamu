<?php

namespace App\Traits;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\ReceiptType;
use Illuminate\Support\Carbon;

trait BreakdownListingsTrait
{
    protected function _next(array $configuration)
    {
        try {
            return collect($configuration['payments'])->map(function ($payment, $key) {
                if($key != 'deposit' && $key != 'late_payment_fine') {
                    return [$key => $payment['amount']];
                }
            })->toArray();
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * > This function returns the current month's invoice for a given unit
     * 
     * @param int id The id of the unit
     * 
     * @return A query builder object.
     */
    protected function _current(int $id)
    {
        try {
            return Invoice::where('unit_id', $id)
                ->where('_status', '!=', Invoice::SETTLED)
                ->whereMonth('_timestamp', Carbon::now()->month)
                ->whereYear('_timestamp', Carbon::now()->year);
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * > It returns the previous invoice of a unit
     * 
     * @param int id The id of the unit
     * 
     * @return A query builder object.
     */
    protected function _previous(int $id)
    {
        try {
            return Invoice::where('unit_id', $id)
                ->where('_status', '!=', Invoice::SETTLED)
                ->whereDate('_timestamp', '<', Carbon::now()->startOfMonth());
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * It returns a collection of invoices for a unit.
     * 
     * @param object unit The unit object
     * 
     * @return A collection of invoices.
     */
    protected function get(object $unit)
    {
        try {
            return collect(array_filter([
                $this->_current($unit->id)->exists() ? [
                    'name' => __('Current Month'),
                    'slug' => 'current',
                    'pids' => $this->_current($unit->id)->get()->map(function ($invoice) {
                        return $invoice->_pid;
                    })->toArray(),
                    'receipts' => $this->make(collect($this->_current($unit->id)->get()->map(function ($invoice) {
                        return extractPID($invoice->_receipt);
                    }))->flatten()->toArray()),
                    'amount' => $this->_current($unit->id)->get()->map(function ($invoice) {
                        return $invoice->balance;
                    })->sum()
                ] : [
                    'name' => __('Next Month'),
                    'slug' => 'next',
                    'pids' => [],
                    'receipts' => array_map('current', collect(array_values(array_filter($this->_next(json_decode($unit->configuration, true)))))->toArray()),
                    'amount' => array_sum(array_map('current', collect(array_values(array_filter($this->_next(json_decode($unit->configuration, true)))))->toArray()))
                ],
                $this->_previous($unit->id)->exists() > 0 ? [
                    'name' => __('Unpaid'),
                    'slug' => 'previous',
                    'pids' => $this->_previous($unit->id)->get()->map(function ($invoice) {
                        return $invoice->_pid;
                    })->toArray(),
                    'receipts' => $this->make(collect($this->_previous($unit->id)->get()->map(function ($invoice) {
                        return extractPID($invoice->_receipt);
                    }))->flatten()->toArray()),
                    'amount' => $this->_previous($unit->id)->get()->map(function ($invoice) {
                        return $invoice->balance;
                    })->sum()
                ] : NULL
            ]));
        } catch (\Throwable $th) {
            throw $th;
            // eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * It takes an array of receipt ids, fetches the receipts from the database, and returns an array
     * of the sum of each receipt type
     * 
     * @param array receipts An array of receipt ids.
     * 
     * @return an array of the sum of the values of the receipts.
     */
    protected function make(array $receipts)
    {
        try {
            $receipts = Receipt::whereIn('_pid', $receipts)
            ->with('type')
            ->get()
            ->map(function ($receipt) {
                $receiptTypes = ReceiptType::get()->map(function ($receiptType) use ($receipt) {
                    $data = [];
                    if($receipt->type->slug == $receiptType->slug) {
                        $data[$receiptType->slug] = $receipt->balance;
                    }

                    return $data;
                })->toArray();

                return array_values(array_filter(array_map('array_filter', $receiptTypes)));

            })->toArray();

            return array_filter([
                'deposit' => array_sum(array_column(collect($receipts)->flatten(1)->toArray(), 'deposit')),
                'rent' => array_sum(array_column(collect($receipts)->flatten(1)->toArray(), 'rent')),
                'water' => array_sum(array_column(collect($receipts)->flatten(1)->toArray(), 'water')),
                'trash' => array_sum(array_column(collect($receipts)->flatten(1)->toArray(), 'trash')),
                'late_payment_fine' => array_sum(array_column(collect($receipts)->flatten(1)->toArray(), 'late_payment_fine')),
                'commission' => array_sum(array_column(collect($receipts)->flatten(1)->toArray(), 'commission')),
                'deposit_refund' => array_sum(array_column(collect($receipts)->flatten(1)->toArray(), 'deposit_refund'))
            ]);
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }
}
