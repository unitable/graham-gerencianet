<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Listeners;

use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Boleto\Boleto;
use Unitable\GrahamGerencianet\Methods\Boleto\Events\BoletoUpdated;

class UpdateInvoiceStatus {

    /**
     * Handle the event.
     *
     * @param BoletoUpdated $event
     * @return void
     */
    public function handle(BoletoUpdated $event) {
        $boleto = $event->boleto;

        $status = null;
        switch ($boleto->status) {
            case Boleto::NEW:
            case Boleto::CONTESTED:
                $status = SubscriptionInvoice::PROCESSING;
            break;
            case Boleto::WAITING:
            case Boleto::LINK:
                $status = SubscriptionInvoice::OPEN;
            break;
            case Boleto::PAID:
            case Boleto::SETTLED:
                $status = SubscriptionInvoice::PAID;
            break;
            case Boleto::UNPAID:
                $status = SubscriptionInvoice::PAST_DUE;
            break;
            case Boleto::EXPIRED:
                $status = SubscriptionInvoice::EXPIRED;
            break;
            case Boleto::REFUNDED:
            case Boleto::CANCELED:
                $status = SubscriptionInvoice::CANCELED;
            break;
        }

        if ($status) {
            $boleto->invoice->update([
                'status' => $status
            ]);
        }
    }

}
