<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Unitable\GrahamGerencianet\Methods\Pix\Pix;

class PixCreated {

    use Dispatchable;

    /**
     * The event pix.
     *
     * @var Pix
     */
    public Pix $pix;

    /**
     * Create a new event instance.
     *
     * @param Pix $pix
     */
    public function __construct(Pix $pix) {
        $this->pix = $pix;
    }

}
