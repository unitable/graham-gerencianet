<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Http\Controllers;

use Gerencianet\Exception\GerencianetException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller {

    /**
     * Handle a Gerencianet webhook call.
     *
     * @param Request $request
     * @return Response
     * @throws GerencianetException
     */
    public function handleWebhook(Request $request): Response {
        return $this->successMethod();
    }

    /**
     * Handle successful calls on the controller.
     *
     * @param array $parameters
     * @return Response
     */
    protected function successMethod($parameters = []): Response {
        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param array $parameters
     * @return Response
     */
    protected function missingMethod($parameters = []): Response {
        return new Response;
    }

}
