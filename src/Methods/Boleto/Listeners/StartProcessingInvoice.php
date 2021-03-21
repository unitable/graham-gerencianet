<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Listeners;

use Unitable\Graham\Events\SubscriptionInvoiceCreated;
use Unitable\GrahamGerencianet\Methods\Boleto\BoletoMethod;
use Unitable\GrahamGerencianet\Methods\Boleto\Jobs\ProcessInvoice;

class StartProcessingInvoice {

    /**
     * Handle the event.
     *
     * @param SubscriptionInvoiceCreated $event
     * @return void
     */
    public function handle(SubscriptionInvoiceCreated $event) {
        $invoice = $event->invoice;

        if ($invoice->method instanceof BoletoMethod) {
            ProcessInvoice::dispatch($invoice);
        }
    }

}
