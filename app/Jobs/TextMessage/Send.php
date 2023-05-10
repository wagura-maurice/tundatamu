<?php

namespace App\Jobs\TextMessage;

use Illuminate\Bus\Queueable;
use App\Broadcasting\ZettaTelChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TextMessageNotification;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class Send implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $textMessage;

    public int $tries = 5;
    public bool $failOnTimeout = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->textMessage = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            /* Sending a notification to the user. */
            Notification::sendNow($this->textMessage['telephone'], new TextMessageNotification($this->textMessage), [ZettaTelChannel::class]);
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
