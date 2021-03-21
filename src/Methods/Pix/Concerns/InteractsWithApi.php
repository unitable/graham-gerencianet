<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Concerns;

use Gerencianet\Exception\GerencianetException;
use Illuminate\Support\Str;
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
        $expires_after = $invoice->due_at
            ->addDay()
            ->diffInSeconds(now());

        $pix = $this->getApi()->pixCreateImmediateCharge([], [
            "calendario" => [
                "expiracao" => $expires_after
            ],
            "valor" => [
                "original" => number_format($invoice->total, 2, '.', '')
            ],
            "chave" => config('graham-gerencianet.pix_key'),
        ]);

        if (!isset($pix['txid']) || !$pix['txid']) {
            throw new \RuntimeException('Pix txid was not found.');
        }

        $qrcode = $this->getApi()->pixGenerateQRCode([
            'id' => $pix['loc']['id']
        ])['qrcode'];

        return Pix::create([
            'status' => Pix::PROCESSING,
            'token' => Str::uuid(),
            'subscription_invoice_id' => $invoice->id,
            'subscription_id' => $invoice->subscription_id,
            'user_id' => $invoice->user_id,
            'gerencianet_txid' => $pix['txid'],
            'total' => $invoice->total,
            'qrcode' => base64_encode($qrcode)
        ]);
    }

}
