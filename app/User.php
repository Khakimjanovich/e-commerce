<?php

namespace App;

use App\Cart\Money;
use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ProductVariation;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'gateway_customer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = bcrypt($user->password);
        });
    }

    public function setOTP()
    {
        $otp = random_int(100000, 999999);

        $this->otp = $otp;
        $this->save();
        // here we should send otp
        $sent = true;

        return $sent;
    }

    public function hasEmail()
    {
        if ($this->email == null) {
            return false;
        }

        return $this->email;
    }

    public function renew($data)
    {
        $this->name = $data['name'];
        if (isset($data['email'])) {
            $this->email = $data['email'];
        }
        $this->save();
    }

    public function cart()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_user')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subtotal()
    {
        $subtotal = $this->cart->sum(function ($product) {
            return $product->price->amount() * $product->pivot->quantity;
        });

        return new Money($subtotal);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }


}
