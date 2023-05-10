<?php

namespace App\Jobs\Transaction;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use App\Interfaces\Mpesa\LNMOInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    // public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    // public $timeout = 120;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    // public $failOnTimeout = true;

    protected $data;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $_data, int $_id)
    {
        $this->data = $_data;
        $this->user = User::where('id', $_id)
            ->with('account')
            ->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LNMOInterface $LNMOInterface)
    {
        try {
            if(optional($this->user)->account) {
                $invoices = Invoice::whereIn('_pid', $this->data)
                    ->where('_status', '!=', Invoice::SETTLED)
                    ->get();

                $data = array_merge(array_filter([
                    'Amount' => (int) $invoices->map(function ($invoice) {
                        return $invoice->balance;
                    })->sum(),
                    'PartyA' => str_replace('+', '', phoneNumberPrefix($this->user->account->telephone)),
                    'PhoneNumber' => str_replace('+', '', phoneNumberPrefix($this->user->account->telephone)),
                    'AccountReference' => generatePID(Transaction::class, 10),
                    'TransactionDesc' => strtoupper('lipa na mpesa online transaction: date; ' . Carbon::now()->format('YmdHis'))
                ]), [
                    '_reference' => $invoices->map(function ($invoice) {
                        return $invoice->_pid;
                    })->toJson(),
                    '_category' => Transaction::INVOICE
                ]);

                return $LNMOInterface->transact($data);
            }

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $th
     * @return void
     */
    public function failed(\Throwable $th)
    {
        // Send user notification of failure, etc...
        eThrowable(get_class($this), $th->getMessage());
    }
}
