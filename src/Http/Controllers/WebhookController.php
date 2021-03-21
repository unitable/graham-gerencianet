<?php

namespace Unitable\GrahamGerencianet\Http\Controllers;

use Gerencianet\Exception\GerencianetException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Unitable\GrahamGerencianet\Events\WebhookHandled;
use Unitable\GrahamGerencianet\Events\WebhookReceived;
use Symfony\Component\HttpFoundation\Response;
use Unitable\GrahamGerencianet\Methods\Boleto\Boleto;

class WebhookController extends Controller {

    /**
     * Handle a Gerencianet webhook call.
     *
     * @param Request $request
     * @return Response
     * @throws GerencianetException
     */
    public function handleWebhook(Request $request): Response {
        $payload = $this->retrievePayload($request);
        $method = 'handle' . Str::studly($payload['type'] . '_StatusUpdated');

        WebhookReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod();
    }

    /**
     * Retrieve a webhook payload.
     *
     * @param Request $request
     * @return array
     * @throws GerencianetException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    protected function retrievePayload(Request $request): ?array {
        $api = app()->make('gerencianet')->default();

        $data = $api->getNotification([
            'token' => $request->get('notification')
        ], [])['data'] ?? null;

        return $data ? $data[count($data) - 1] : null;
    }

    /**
     * Handle status updated for charge.
     *
     * @param array $payload
     * @return Response
     */
    protected function handleChargeStatusUpdated(array $payload): Response {
        $charge_id = $payload['identifiers']['charge_id'];

        if ($boleto = Boleto::findByGerencianetChargeId($charge_id)) {
            $boleto->update([
                'status' => $payload['status']['current']
            ]);
        }

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
