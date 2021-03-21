<?php

namespace Unitable\GrahamGerencianet\Methods\Pix;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Unitable\Graham\Subscription\SubscriptionInvoice;
use Unitable\Graham\Support\Model;

/**
 * @property string $status
 * @property string $gerencianet_pix_url
 * @property SubscriptionInvoice $invoice
 */
class Pix extends Model {

    const PROCESSING = 'PROCESSING';
    const OPEN = 'ATIVA';
    const PAID = 'CONCLUIDA';
    const CANCELED_BY_USER = 'REMOVIDA_PELO_USUARIO_RECEBEDOR';
    const CANCELED_BY_PSP = 'REMOVIDA_PELO_PSP';

    const ACTIVE = [
        'PROCESSING', 'ATIVA'
    ];

    protected $table = 'gerencianet_pix';

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
     * Find by Gerencianet Pix method id.
     *
     * @param int $method_id
     * @return static|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findByGerencianetPixMethodId(int $method_id) {
        return static::query()
            ->where('gerencianet_pix_method_id', $method_id)
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
