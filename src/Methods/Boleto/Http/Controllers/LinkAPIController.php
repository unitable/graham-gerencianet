<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Boleto\Http\Middleware\AuthorizeLinkAPI;
use Unitable\GrahamGerencianet\Methods\Boleto\Boleto;

class LinkAPIController extends Controller {

    const PROCESSING = 'processing';
    const ACTIVE = 'active';
    const PAID = 'paid';
    const CANCELED = 'canceled';

    /**
     * QRCodeAPIController constructor.
     */
    public function __construct() {
        $this->middleware(AuthorizeLinkAPI::class);
    }

    /**
     * Handle the API request.
     *
     * @param Request $request
     * @return string[]
     */
    public function handleRequest(Request $request) {
        $payload = $request->validate([
            'invoice_id' => 'required|integer'
        ]);

        if ($invoice = SubscriptionInvoice::find((int) $payload['invoice_id'])) {
            $boleto = $this->findOrCreateBoletoForInvoice($invoice);

            return [
                'status' => $this->resolveLinkStatus($boleto),
                'url' => $boleto->gerencianet_boleto_url
            ];
        }

        return null;
    }

    /**
     * Find or create a Boleto payment for the invoice.
     *
     * @param SubscriptionInvoice $invoice
     * @return Boleto
     */
    protected function findOrCreateBoletoForInvoice(SubscriptionInvoice $invoice): Boleto {
        return ($boleto = Boleto::findBySubscriptionInvoiceId($invoice->id)) ?
            $boleto : $invoice->method->newBoleto($invoice);
    }

    /**
     * Resolve the link status code of a boleto payment.
     *
     * @param Boleto $boleto
     * @return string
     */
    protected function resolveLinkStatus(Boleto $boleto): string {
        // Status API is too slow, check url instead.
        $status = $boleto->gerencianet_boleto_url ?
            static::ACTIVE : static::PROCESSING;

        switch ($boleto->status) {
            case Boleto::REFUNDED:
            case Boleto::CONTESTED:
            case Boleto::CANCELED:
            case Boleto::EXPIRED:
                $status = static::CANCELED;
            break;
        }

        return $status;
    }

}
