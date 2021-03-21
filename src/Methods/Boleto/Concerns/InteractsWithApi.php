<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Concerns;

use Gerencianet\Exception\GerencianetException;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Entities\Boleto as BoletoEntity;
use Unitable\GrahamGerencianet\Gerencianet;
use Unitable\GrahamGerencianet\Methods\Boleto\Boleto;

trait InteractsWithApi {

    /**
     * Get the api.
     *
     * @return Gerencianet
     */
    public function getApi(): Gerencianet {
        return app()->make('gerencianet');
    }

    /**
     * Greate a boleto.
     *
     * @param SubscriptionInvoice $invoice
     * @return Boleto
     * @throws GerencianetException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function newBoleto(SubscriptionInvoice $invoice): Boleto {
        $item_name = str_replace([
            '%plan_name%', '%plan_price_name%'
        ], [
            $invoice->plan->name, $invoice->plan_price->name
        ], config('graham-gerencianet.invoice_item_name'));
        $item_value = $invoice->total * 100;

        $webhook_url = config('graham-gerencianet.webhook_url') ??
            route('graham-gerencianet.webhook');

        $data = $this->getApi()->oneStep([
            'metadata' => [
                'notification_url' => $webhook_url
            ],
            'items' => [
                [
                    'name' => $item_name,
                    'amount' => 1,
                    'value' => $item_value
                ]
            ],
            'payment' => [
                'banking_billet' => [
                    'expire_at' => $invoice->due_at->format('Y-m-d') ?? null,
                    'customer' => [
                        'name' => $this->name,
                        'cpf' => $this->cpf,
                        'phone_number' => $this->phone
                    ]
                ]
            ]
        ])['data'] ?? null;

        $boleto = new BoletoEntity($data);

        return Boleto::create([
            'status' => $boleto->status,
            'gerencianet_boleto_method_id' => $this->id,
            'subscription_invoice_id' => $invoice->id,
            'subscription_id' => $invoice->subscription_id,
            'user_id' => $this->user_id,
            'gerencianet_charge_id' => $charge->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'phone' => $this->phone,
            'total' => $invoice->total,
            'gerencianet_boleto_url' => $boleto->url
        ]);
    }

}
