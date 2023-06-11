<?php

namespace App\Support\Services;

use App\Support\Definitions\PaymentMethods;

class PaymentFactory
{
    public function initializePayment(string $type)
    {
        return match ($type) {
            PaymentMethods::PLACE_TO_PAY->value => new PlaceToPayPayment(),
            default => throw new UnsupportedPaymentMethod('el metodo no es soportado')
        }
    }
}
