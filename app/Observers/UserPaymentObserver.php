<?php

namespace App\Observers;

use App\Models\UserPayment;

class UserPaymentObserver
{
    public function created(UserPayment $userPayment)
    {
        $payment = $userPayment->payment;
        $totalAmount = $payment->amount;
        $usersCount = $payment->users_count;

        foreach ($payment->userPayments as $userPayment) {
            $userPaymentAmount = $totalAmount / $usersCount;
            $userPayment->update(['amount' => $userPaymentAmount]);
        }
    }

    public function updated(UserPayment $userPayment)
    {
        $payment = $userPayment->payment;

        $payment->amount = $payment->userPayments->sum('amount');
        $payment->saveQuietly();
    }
}
