<?php

namespace Unitable\GrahamGerencianet\Methods\Pix\Observers;

use Unitable\GrahamGerencianet\Methods\Pix\Pix;
use Unitable\GrahamGerencianet\Methods\Pix\Events\PixCreated;
use Unitable\GrahamGerencianet\Methods\Pix\Events\PixPaid;
use Unitable\GrahamGerencianet\Methods\Pix\Events\PixUpdated;

class PixObserver {

    /**
     * Handle the pix "created" event.
     *
     * @param Pix $pix
     * @return void
     */
    public function created(Pix $pix) {
        PixCreated::dispatch($pix);

        $this->dispatchStatuses($pix);
    }

    /**
     * Handle the pix "updated" event.
     *
     * @param Pix $pix
     * @return void
     */
    public function updated(Pix $pix) {
        PixUpdated::dispatch($pix);

        if ($pix->isDirty('status')) {
            $this->dispatchStatuses($pix);
        }
    }

    /**
     * Dispatch statuses events.
     *
     * @param Pix $pix
     * @return void
     */
    protected function dispatchStatuses(Pix $pix) {
        switch ($pix->status) {
            case Pix::PAID:
                PixPaid::dispatch($pix);
            break;
        }
    }

}
