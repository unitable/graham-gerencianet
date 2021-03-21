<?php

namespace Unitable\GrahamGerencianet\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebhookReceived {

    use Dispatchable, SerializesModels;

    /**
     * The postback payload.
     *
     * @var array
     */
    public array $payload;

    /**
     * Create a new event instance.
     *
     * @param  array  $payload
     * @return void
     */
    public function __construct(array $payload) {
        $this->payload = $payload;
    }

}
