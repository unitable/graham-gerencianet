<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Pix\Http\Middleware\AuthorizeQRCodeAPI;
use Unitable\GrahamGerencianet\Methods\Pix\Pix;

class QRCodeAPIController extends Controller {

    const PROCESSING = 'processing';
    const ACTIVE = 'active';
    const PAID = 'paid';
    const CANCELED = 'canceled';

    /**
     * QRCodeAPIController constructor.
     */
    public function __construct() {
        $this->middleware(AuthorizeQRCodeAPI::class);
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
            $pix = $this->findOrCreatePixForInvoice($invoice);

            return [
                'status' => $this->resolveQRCodeStatus($pix),
                'qrcode_text' => $pix->gerencianet_qrcode
            ];
        }

        return null;
    }

    /**
     * Find or create a Pix payment for the invoice.
     *
     * @param SubscriptionInvoice $invoice
     * @return Pix
     */
    protected function findOrCreatePixForInvoice(SubscriptionInvoice $invoice): Pix {
        return ($pix = Pix::findBySubscriptionInvoiceId($invoice->id)) ?
            $pix : $invoice->method->newPix($invoice);
    }

    /**
     * Resolve the QR Code status code of a Pix payment.
     *
     * @param Pix $pix
     * @return string
     */
    protected function resolveQRCodeStatus(Pix $pix): string {
        $status = static::PROCESSING;

        switch ($pix->status) {
            case Pix::OPEN:
                $status = static::ACTIVE;
            break;
            case Pix::PAID:
                $status = static::PAID;
            break;
            case Pix::CANCELED_BY_USER:
            case Pix::CANCELED_BY_PSP:
                $status = static::CANCELED;
            break;
        }

        return $status;
    }

}
