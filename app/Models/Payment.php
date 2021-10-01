<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Payment extends Model
{
    use HasFactory;
    use Actionable;

    protected $guarded = ['id'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $withCount = [
        'users'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'payment_shares')->using(PaymentShare::class);
    }

    public function shares()
    {
        return $this->hasMany(PaymentShare::class);
    }
}
