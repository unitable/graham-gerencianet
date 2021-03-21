<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Jobs;

use Gerencianet\Exception\GerencianetException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\GrahamGerencianet\Methods\Boleto\BoletoMethod;

class ProcessInvoice implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The job invoice.
     *
     * @var SubscriptionInvoice
     */
    protected SubscriptionInvoice $invoice;

    /**
     * The job invoice method.
     *
     * @var BoletoMethod
     */
    protected BoletoMethod $method;

    /**
     * Create a new job instance.
     *
     * @param SubscriptionInvoice $invoice
     */
    public function __construct(SubscriptionInvoice $invoice) {
        $this->invoice = $invoice;
        $this->method = $invoice->method;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws GerencianetException
     */
    public function handle() {
        if ($this->invoice->status === SubscriptionInvoice::PROCESSING) {
            $this->method->newBoleto($this->invoice);
        }
    }

}
