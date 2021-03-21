<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Unitable\GrahamGerencianet\Methods\Boleto\Boleto;

class BoletoCreated {

    use Dispatchable;

    /**
     * The event boleto.
     *
     * @var Boleto
     */
    public Boleto $boleto;

    /**
     * Create a new event instance.
     *
     * @param Boleto $boleto
     */
    public function __construct(Boleto $boleto) {
        $this->boleto = $boleto;
    }

}
