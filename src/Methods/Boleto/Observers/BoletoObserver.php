<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Observers;

use Unitable\GrahamGerencianet\Methods\Boleto\Boleto;
use Unitable\GrahamGerencianet\Methods\Boleto\Events\BoletoCreated;
use Unitable\GrahamGerencianet\Methods\Boleto\Events\BoletoPaid;
use Unitable\GrahamGerencianet\Methods\Boleto\Events\BoletoUpdated;

class BoletoObserver {

    /**
     * Handle the boleto "created" event.
     *
     * @param Boleto $boleto
     * @return void
     */
    public function created(Boleto $boleto) {
        BoletoCreated::dispatch($boleto);

        $this->dispatchStatuses($boleto);
    }

    /**
     * Handle the boleto "updated" event.
     *
     * @param Boleto $boleto
     * @return void
     */
    public function updated(Boleto $boleto) {
        BoletoUpdated::dispatch($boleto);

        if ($boleto->wasChanged('status')) {
            $this->dispatchStatuses($boleto);
        }
    }

    /**
     * Dispatch statuses events.
     *
     * @param Boleto $boleto
     * @return void
     */
    protected function dispatchStatuses(Boleto $boleto) {
        switch ($boleto->status) {
            case Boleto::PAID:
            case Boleto::SETTLED:
                BoletoPaid::dispatch($boleto);
            break;
        }
    }

}
