<?php

namespace Unitable\GrahamGerencianet\Entities;

use Illuminate\Support\Str;

abstract class Entity {

    /**
     * The entity data.
     *
     * @var array
     */
    protected array $data;

    /**
     * Entity constructor.
     *
     * @param array $data
     */
    public function __construct(array $data) {
        return $this->data = $data;
    }

    /**
     * Get a data.
     *
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        $getter = 'get' . Str::studly($key) . 'Attribute';

        if (method_exists($this, $getter))
            return $this->{$getter}();

        return $this->data[$key] ?? null;
    }

}
