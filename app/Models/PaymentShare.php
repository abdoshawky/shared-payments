<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Znck\Eloquent\Traits\BelongsToThrough;

class PaymentShare extends Pivot
{
    use HasFactory;
    use BelongsToThrough;

    protected $table = "payment_shares";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function paidBy()
    {
        return $this->belongsToThrough(User::class, Payment::class, null, '', [User::class => 'paid_by']);
    }
}
