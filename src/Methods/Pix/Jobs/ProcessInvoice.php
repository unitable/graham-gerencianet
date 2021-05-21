<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Unitable\Graham\Subscription\SubscriptionInvoice;

class ProcessInvoice {

    use Dispatchable;

    /**
     * The job invoice.
     *
     * @var SubscriptionInvoice
     */
    protected SubscriptionInvoice $invoice;

    /**
     * Create a new job instance.
     *
     * @param SubscriptionInvoice $invoice
     */
    public function __construct(SubscriptionInvoice $invoice) {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->invoice->update([
            'status' => SubscriptionInvoice::OPEN
        ]);
    }

}
