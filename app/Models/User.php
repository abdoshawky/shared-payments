<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'payment_shares')->using(PaymentShare::class);
    }

    public function shares()
    {
        return $this->hasMany(PaymentShare::class);
    }

    public function getDebtsAttribute()
    {
        // How much do I own to other users
        $usersMoney = $this->shares()
            ->whereHas('payment', function ($query) {
                $query->where('completed', 0)->where('paid_by', '!=', $this->id);
            })
            ->sum('share');

        // How mush does other users own me
        $myMoney = PaymentShare::where('user_id', '!=', $this->id)
            ->whereHas('payment', function ($query) {
                $query->where('completed', 0)->where('paid_by', $this->id);
            })
            ->sum('share');

        return $usersMoney - $myMoney;
    }

    public function getDebitsToUser(User $user)
    {
        // How much do I own to this user
        $userMoney = $this->shares()
            ->whereHas('payment', function ($query) use ($user) {
                $query->where('completed', 0)->where('paid_by', $user->id);
            })
            ->sum('share');

        // How mush does this user owns to me
        $myMoney = $user->shares()
            ->whereHas('payment', function ($query){
                $query->where('completed', 0)->where('paid_by', $this->id);
            })
            ->sum('share');

        return $userMoney - $myMoney;
    }
}
