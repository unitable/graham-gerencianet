<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Concerns;

use Gerencianet\Exception\GerencianetException;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Pix\Pix;

trait InteractsWithApi {

    /**
     * Get the api.
     *
     * @return mixed
     */
    public function getApi() {
        return app()->make('gerencianet')->pix();
    }

    /**
     * Create a pix.
     *
     * @param SubscriptionInvoice $invoice
     * @return Pix
     * @throws GerencianetException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function newPix(SubscriptionInvoice $invoice): Pix {
        $item_name = str_replace([
            '%plan_name%', '%plan_price_name%'
        ], [
            $invoice->plan->name, $invoice->plan_price->name
        ], config('graham-gerencianet.invoice_item_name'));

        $expires_after = $invoice->due_at
            ->addDay()
            ->diffInSeconds(now());

        $pix = $this->getApi()->pixCreateImmediateCharge([], [
            "chave" => config('graham-gerencianet.pix_key'),
            "valor" => [
                "original" => number_format($invoice->total, 2, '.', '')
            ],
            "calendario" => [
                "expiracao" => $expires_after
            ],
            "infoAdicionais" => [
                ['nome' => __('graham-gerencianet::pix.plan'), 'valor' => $item_name],
            ]
        ]);

        if (!isset($pix['txid']) || !$pix['txid']) {
            throw new \RuntimeException('Pix txid was not found.');
        }

        $qrcode = $this->getApi()->pixGenerateQRCode([
            'id' => $pix['loc']['id']
        ])['qrcode'];

        return Pix::create([
            'status' => $pix['status'],
            'subscription_invoice_id' => $invoice->id,
            'subscription_id' => $invoice->subscription_id,
            'user_id' => $invoice->user_id,
            'total' => $invoice->total,
            'gerencianet_txid' => $pix['txid'],
            'gerencianet_qrcode' => $qrcode
        ]);
    }

}
