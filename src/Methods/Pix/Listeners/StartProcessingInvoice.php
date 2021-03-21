<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Listeners;

use Unitable\Graham\Events\SubscriptionInvoiceCreated;
use Unitable\GrahamGerencianet\Methods\Pix\PixMethod;
use Unitable\GrahamGerencianet\Methods\Pix\Jobs\ProcessInvoice;

class StartProcessingInvoice {

    /**
     * Handle the event.
     *
     * @param SubscriptionInvoiceCreated $event
     * @return void
     */
    public function handle(SubscriptionInvoiceCreated $event) {
        $invoice = $event->invoice;

        if ($invoice->method instanceof PixMethod) {
            ProcessInvoice::dispatch($invoice);
        }
    }

}
