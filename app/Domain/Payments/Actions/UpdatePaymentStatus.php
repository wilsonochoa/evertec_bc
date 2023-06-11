<?php

namespace App\Domain\Payments\Actions;

use App\Domain\Payments\Models\Payment;
use App\Support\Actions\Action;

class UpdatePaymentStatus implements Action
{
    public static function execute(array $params): bool
    {
        return Payment::where('id', $params['id'])->update(['status' => $params['status']]);
    }
}
