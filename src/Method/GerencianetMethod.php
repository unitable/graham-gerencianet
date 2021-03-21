<?php

namespace Unitable\GrahamGerencianet\Method;

use Unitable\Graham\Method\Method as BaseMethod;

abstract class GerencianetMethod extends BaseMethod {

    /**
     * Find by subscription id.
     *
     * @param int $subscription_id
     * @return static|null
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public static function findBySubscriptionId(int $subscription_id) {
        return static::query()->where('subscription_id', $subscription_id)->first();
    }

}
