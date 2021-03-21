<?php

namespace Unitable\GrahamGerencianet;

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet as Client;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Entities\Charge;

class Gerencianet extends Client {

    /**
     * Create a new transaction.
     *
     * @param SubscriptionInvoice $invoice
     * @return Charge
     * @throws GerencianetException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function newCharge(SubscriptionInvoice $invoice): ?Charge {
        $item_name = str_replace([
            '%plan_name%', '%plan_price_name%'
        ], [
            $invoice->plan->name, $invoice->plan_price->name
        ], config('graham-gerencianet.invoice_item_name'));
        $item_value = $invoice->total * 100;

        $webhook_url = config('graham-gerencianet.webhook_url') ??
            route('graham-gerencianet.webhook');

        $data = $this->createCharge([], [
            'metadata' => [
                'notification_url' => $webhook_url
            ],
            'items' => [
                [
                    'name' => $item_name,
                    'amount' => 1,
                    'value' => $item_value
                ]
            ]
        ])['data'] ?? null;

        return $data ? new Charge($data) : null;
    }

}
