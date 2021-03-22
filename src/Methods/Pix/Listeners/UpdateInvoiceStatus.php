<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Listeners;

use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Pix\Events\PixCreated;
use Unitable\GrahamGerencianet\Methods\Pix\Events\PixUpdated;
use Unitable\GrahamGerencianet\Methods\Pix\Pix;

class UpdateInvoiceStatus {

    /**
     * Handle the event.
     *
     * @param PixCreated|PixUpdated $event
     * @return void
     */
    public function handle($event) {
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
