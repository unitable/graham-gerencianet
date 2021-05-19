<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto\Http\Middleware;

use Illuminate\Http\Request;

class AuthorizeLinkAPI {

    /**
     * Handle the QR Code API request authorization.
     *
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request, \Closure $next) {
        return response(null, 401);
    }

}
