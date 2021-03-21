<?php

namespace Unitable\GrahamGerencianet;

use Gerencianet\Gerencianet as Client;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;

class Gerencianet extends Container {

    /**
     * Gerencianet constructor.
     *
     * @param array $options
     */
    public function __construct(array $options) {
        $this->singleton('default', function() use($options) {
            $options = collect($options)
                ->except('pix_cert')
                ->toArray();

            return new Client($options);
        });

        $this->singleton('pix', function() use($options) {
            return new Client($options);
        });
    }

    /**
     * Get the default client.
     *
     * @return Client
     */
    public function default(): Client {
        return $this->make('default');
    }

    /**
     * Get the Pix client.
     *
     * @return Client
     */
    public function pix(): Client {
        return $this->make('pix');
    }

}
