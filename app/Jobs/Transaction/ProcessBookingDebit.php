<?php

namespace App\Jobs\Transaction;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Tenancy;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Models\BookingCategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessBookingDebit implements ShouldQueue
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $invoice = Invoice::find($this->data['id']);
            $tenancy = Tenancy::find($this->data['tenancy_id']);
            $category = BookingCategory::where('slug', 'reconciliation')->first();

            if(optional($invoice)->id && optional($tenancy)->id && optional($tenancy)->booking > 0) {
                /* Checking if the invoice balance is less than or equal to the tenancy booking. If it
                is, it will add the invoice balance to the invoice paid and set the invoice balance
                to zero. It will then set the change to the tenancy booking minus the invoice
                balance. If the invoice balance is greater than the tenancy booking, it will add the
                tenancy booking to the invoice paid and subtract the tenancy booking from the
                invoice balance. It will then set the change to the tenancy booking. */
                if ($invoice->balance <= $tenancy->booking) {
                    $invoice->paid = $invoice->paid + $invoice->balance;
                    $invoice->balance = 0;
                    $change = $tenancy->booking - $invoice->balance;
                } else {
                    $invoice->paid = $invoice->paid + $tenancy->booking;
                    $invoice->balance = $invoice->balance - $tenancy->booking;
                    $change = $tenancy->booking;
                }

                $invoice->save();

                $booking = new Booking;
                $booking->_pid = generatePID(Booking::class);
                $booking->category_id = $category->id;
                $booking->property_id = $invoice->property_id;
                $booking->unit_id = $invoice->unit_id;
                $booking->user_id = $invoice->user_id;
                $booking->tenancy_id = $tenancy->id;
                $booking->amount = $change;
                $booking->description = strtoupper('tenancy; ' . $tenancy->_pid . ' reconciliation @; ' . Carbon::now()->format('g:i A, l jS, F Y.'));
                $booking->save();
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
