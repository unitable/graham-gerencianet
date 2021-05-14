<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto;

use Unitable\Graham\Engines\Hosted\HostedEngine;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Method\GerencianetMethod;

/**
 * @property HostedEngine $engine
 */
final class BoletoMethod extends GerencianetMethod {

   use Concerns\InteractsWithApi;

    protected $table = 'gerencianet_boleto_methods';

    protected $guarded = [];

    /**
     * Get an invoice payment info.
     *
     * @param SubscriptionInvoice $invoice
     * @return array|null
     */
    public function getInvoicePaymentInfo(SubscriptionInvoice $invoice): ?array {
        return ($boleto = Boleto::findBySubscriptionInvoiceId($invoice->id)) ? [
            'type' => 'url',
            'method' => 'gerencianet_boleto',
            'url' => $boleto->gerencianet_boleto_url
        ] : null;
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
