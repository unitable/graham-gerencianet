<?php

namespace Unitable\GrahamGerencianet\Entities;

use Illuminate\Support\Carbon;

/**
 * @property int $charge_id
 * @property string $status
 * @property float $total
 * @property string $barcode
 * @property string $url
 * @property string $pdf_url
 * @property ?Carbon $expire_at
 */
class Boleto extends Entity {

    /**
     * @return int
     */
    public function getChargeIdAttribute(): int {
        return $this->data['charge_id'];
    }

    /**
     * @return float
     */
    public function getTotalAttribute(): float {
        return $this->data['total'] / 100;
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string {
        return $this->data['link'];
    }

    /**
     * @return string
     */
    public function getPdfUrlAttribute(): string {
        return $this->data['pdf']['charge'];
    }

    /**
     * @return Carbon|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function getExpireAtAttribute(): ?Carbon {
        return isset($this->data['expire_at']) ?
            Carbon::createFromFormat('Y-m-d', $this->data['expire_at']) : null;
    }

}
