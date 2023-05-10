<?php

namespace App\Jobs\TextMessage;

use App\Models\TextMessage;
use Illuminate\Bus\Queueable;
use App\Models\CommunicationCategory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class Generate implements ShouldQueue
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

    protected $category;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $category, array $data)
    {
        $this->category = $category;
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
            $comms = CommunicationCategory::where('slug', $this->category)->first();

            /* Checking if the communication category exists. */
            if(optional($comms)->id) {
                $textMessage = new TextMessage;
                $textMessage->category_id = $comms->id;
                $textMessage->content = _parse(__($comms->template), $this->data);
                $textMessage->telephone = $this->data['PHONE_NUMBER'];
                $textMessage->save();
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
