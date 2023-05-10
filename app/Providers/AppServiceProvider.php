<?php

namespace App\Providers;

use App\Models\TextMessage;
use App\Models\Transaction;
use Illuminate\Support\Facades\URL;
use App\Observers\TextMessageObserver;
use App\Observers\TransactionObserver;
use Illuminate\Support\Facades\Schema;
use App\Interfaces\Mpesa\LNMOInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Mpesa\LNMORepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // App Environment.
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // App Db Schema.
        Schema::defaultStringLength(191);

        // App Interface to repositories biding.
        // $this->app->bind(IPNInterface::class, IPNRepository::class);
        $this->app->bind(LNMOInterface::class, LNMORepository::class);

        // App Observers.
        Transaction::observe(TransactionObserver::class);
        TextMessage::observe(TextMessageObserver::class);
    }
}
