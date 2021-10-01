<?php

namespace App\Observers;

use App\Models\PaymentShare;

class UserPaymentObserver
{
    public function created(PaymentShare $paymentShare)
    {
        $payment = $paymentShare->payment;
        $totalAmount = $payment->amount;
        $usersCount = $payment->users_count;

        foreach ($payment->shares as $share) {
            $shareAmount = $totalAmount / $usersCount;
            $share->update(['share' => $shareAmount]);
        }
    }

    public function updated(PaymentShare $paymentShare)
    {
        $payment = $paymentShare->payment;

        $payment->amount = $payment->shares->sum('share');
        $payment->saveQuietly();
    }
}
