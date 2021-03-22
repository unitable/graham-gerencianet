<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Http\Controllers;

use Gerencianet\Exception\GerencianetException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Unitable\GrahamGerencianet\Methods\Pix\Pix;

class WebhookController extends Controller {

    /**
     * Get the api.
     *
     * @return mixed
     */
    public function getApi() {
        return app()->make('gerencianet')->pix();
    }

    /**
     * Handle a Gerencianet webhook call.
     *
     * @param Request $request
     * @return Response
     * @throws GerencianetException
     */
    public function handleWebhook(Request $request): Response {
        $items = $request->validate([
            'pix' => 'required|array',
            'pix.*.endToEndId' => 'required|string',
            'pix.*.chave' => 'required|string',
            'pix.*.txid' => 'required|string'
        ])['pix'];

        foreach ($items as $item) {
            $payload = $this->getApi()->pixSendList(['e2eId' => $item['endToEndId']]);

            if ($pix = Pix::findByGerencianetTxid($payload['txid'])) {
                $pix->update([
                    'status' => Pix::PAID,
                    'gerencianet_e2eid' => $payload['endToEndId'],
                ]);
            }
        }

        return $this->successMethod();
    }

    /**
     * Retrieve a Pix payload.
     *
     * @param string $e2eid
     */
    protected function retrievePayloadFromE2eid(string $e2eid) {

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
