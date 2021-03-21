<?php

namespace Unitable\GrahamGerencianet\Entities;

use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $status
 * @property float $total
 * @property mixed $reference
 * @property Carbon $created_at
 */
class Charge extends Entity {

    /**
     * @return int
     */
    public function getIdAttribute(): int {
        return $this->data['charge_id'];
    }

    /**
     * @return float
     */
    public function getTotalAttribute(): float {
        return $this->data['total'] / 100;
    }

    /**
     * @return mixed
     */
    public function getReferenceAttribute() {
        return $this->data['custom_id'];
    }

    /**
     * @return Carbon
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function getCreatedAtAttribute(): Carbon {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->data['created_at']);
    }

}
