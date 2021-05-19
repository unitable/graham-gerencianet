<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Unitable\Graham\Subscription\SubscriptionInvoice;

class ProcessInvoice implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
