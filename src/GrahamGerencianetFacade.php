<?php

namespace Unitable\GrahamGerencianet;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Unitable\GrahamGerencianet\GrahamGerencianet
 */
class GrahamGerencianetFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'graham-gerencianet';
    }

}
