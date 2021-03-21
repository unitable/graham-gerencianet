<?php

namespace Unitable\GrahamGerencianet\Methods\Pix;

use Unitable\Graham\Engines\Hosted\HostedEngine;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Method\GerencianetMethod;

/**
 * @property HostedEngine $engine
 */
final class PixMethod extends GerencianetMethod {

    use Concerns\InteractsWithApi;

    public $exists = false;

    /**
     * Get an invoice payment url.
     *
     * @param SubscriptionInvoice $invoice
     * @return string|null
     */
    public function getInvoicePaymentUrl(SubscriptionInvoice $invoice): ?string {
        $pix = Pix::findBySubscriptionInvoiceId($invoice->id);

        return $pix ? $pix->gerencianet_pix_url : null;
    }

    /**
     * Get the engine.
     *
     * @return HostedEngine
     */
    public function getEngineAttribute(): HostedEngine {
        return app()->make(HostedEngine::class);
    }

}
