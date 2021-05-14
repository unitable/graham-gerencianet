<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Http\Middleware;

use Illuminate\Http\Request;

class AuthorizeQRCodeAPI {

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
