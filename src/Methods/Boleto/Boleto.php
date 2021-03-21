<?php

namespace Unitable\GrahamGerencianet\Methods\Boleto;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\Graham\Support\Model;

/**
 * @property string $status
 * @property string $gerencianet_boleto_url
 * @property SubscriptionInvoice $invoice
 */
class Boleto extends Model {

    const PROCESSING = 'processing';
    const NEW = 'new';
    const WAITING = 'waiting';
    const PAID = 'paid';
    const SETTLED = 'settled';
    const UNPAID = 'unpaid';
    const REFUNDED = 'refunded';
    const CONTESTED = 'contested';
    const CANCELED = 'canceled';
    const LINK = 'link';
    const EXPIRED = 'expired';

    const ACTIVE = [
        'processing', 'new', 'waiting', 'link'
    ];

    protected $table = 'gerencianet_boletos';

    protected $guarded = [];

    /**
     * Find by Gerencianet charge id.
     *
     * @param int $charge_id
     * @return static|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findByGerencianetChargeId(int $charge_id) {
        return static::query()
            ->where('gerencianet_charge_id', $charge_id)
            ->first();
    }

    /**
     * Find by Gerencianet Boleto method id.
     *
     * @param int $method_id
     * @return static|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findByGerencianetBoletoMethodId(int $method_id) {
        return static::query()
            ->where('gerencianet_boleto_method_id', $method_id)
            ->first();
    }

    /**
     * Find by subscription id.
     *
     * @param int $subscription_id
     * @return static|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findBySubscriptionId(int $subscription_id) {
        return static::query()
            ->where('subscription_id', $subscription_id)
            ->first();
    }

    /**
     * Find by subscription invoice id.
     *
     * @param int $subscription_invoice_id
     * @return static|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findBySubscriptionInvoiceId(int $subscription_invoice_id) {
        return static::query()
            ->where('subscription_invoice_id', $subscription_invoice_id)
            ->first();
    }

    /**
     * Get the invoice model.
     *
     * @return BelongsTo
     */
    public function invoice(): BelongsTo {
        return $this->belongsTo(SubscriptionInvoice::class, 'subscription_invoice_id');
    }

}
