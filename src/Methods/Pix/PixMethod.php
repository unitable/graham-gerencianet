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

    /**
     * Get an invoice payment info.
     *
     * @param SubscriptionInvoice $invoice
     * @return array|null
     */
    public function getInvoicePaymentInfo(SubscriptionInvoice $invoice): ?array {
        return [
            'type' => 'qrcode-api',
            'method' => 'gerencianet_pix',
            'qrcode_api' => route('graham-gerencianet.pix.qrcode_api')
        ];
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
