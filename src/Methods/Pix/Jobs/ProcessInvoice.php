<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Jobs;

use Gerencianet\Exception\GerencianetException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Pix\PixMethod;

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
     * @throws GerencianetException
     */
    public function handle() {
        /** @var PixMethod $method */
        $method = $this->invoice->method; // Do not use SerializesModels for the Pix method.

        if ($this->invoice->status === SubscriptionInvoice::PROCESSING) {
            $method->newPix($this->invoice);
        }
    }

}
