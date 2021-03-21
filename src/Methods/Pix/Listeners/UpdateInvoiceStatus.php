<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Listeners;

use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Pix\Pix;
use Unitable\GrahamGerencianet\Methods\Pix\Events\PixUpdated;

class UpdateInvoiceStatus {

    /**
     * Handle the event.
     *
     * @param PixUpdated $event
     * @return void
     */
    public function handle(PixUpdated $event) {
        $pix = $event->pix;

        $status = null;
        switch ($pix->status) {
            case Pix::OPEN:
                $status = SubscriptionInvoice::OPEN;
            break;
            case Pix::PAID:
                $status = SubscriptionInvoice::PAID;
            break;
            case Pix::CANCELED_BY_USER:
            case Pix::CANCELED_BY_PSP:
                $status = SubscriptionInvoice::CANCELED;
            break;
        }

        if ($status) {
            $pix->invoice->update([
                'status' => $status
            ]);
        }
    }

}
