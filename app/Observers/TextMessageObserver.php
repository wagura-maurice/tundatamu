<?php

namespace App\Observers;

use App\Models\TextMessage;
use App\Jobs\TextMessage\Send;

class TextMessageObserver
{
    /**
     * Handle the TextMessage "created" event.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return void
     */
    public function created(TextMessage $textMessage)
    {
        /* Dispatching a job to the queue. */
        Send::dispatch($textMessage->toArray());
    }

    /**
     * Handle the TextMessage "updated" event.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return void
     */
    public function updated(TextMessage $textMessage)
    {
        //
    }

    /**
     * Handle the TextMessage "deleted" event.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return void
     */
    public function deleted(TextMessage $textMessage)
    {
        //
    }

    /**
     * Handle the TextMessage "restored" event.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return void
     */
    public function restored(TextMessage $textMessage)
    {
        //
    }

    /**
     * Handle the TextMessage "force deleted" event.
     *
     * @param  \App\Models\TextMessage  $textMessage
     * @return void
     */
    public function forceDeleted(TextMessage $textMessage)
    {
        //
    }
}
