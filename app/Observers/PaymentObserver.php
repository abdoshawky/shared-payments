<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    public function creating(Payment $payment)
    {
        if(auth()->check()){
            $payment->created_by = auth()->id();
        }
    }
}
