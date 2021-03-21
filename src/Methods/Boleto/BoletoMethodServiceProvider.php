<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Unitable\Graham;
use Unitable\GrahamGerencianet\Methods\Boleto\Observers\BoletoObserver;

class BoletoMethodServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->registerEvents();
        $this->registerObservers();
    }

    /**
     * Register any application events.
     *
     * @return void
     */
    protected function registerEvents() {
        Event::listen(Graham\Events\SubscriptionInvoiceCreated::class, Listeners\StartProcessingInvoice::class);
        Event::listen(Events\BoletoCreated::class, Listeners\UpdateInvoiceStatus::class);
        Event::listen(Events\BoletoUpdated::class, Listeners\UpdateInvoiceStatus::class);
    }

    /**
     * Register any application observers.
     *
     * @return void
     */
    protected function registerObservers() {
        Boleto::observe(BoletoObserver::class);
    }

}
