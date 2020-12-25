<?php

namespace App\Providers;

use App\Cart\Cart;
use App\Payments\Gateway;
use App\Payments\Gateways\StripeGateWay;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class,function ($app){

            if ($app->request->user()){
                $app->request->user()->load([
                    'cart.stock'
                ]);
            }
           return new Cart($app->request->user());
        });

        $this->app->singleton(Gateway::class, function (){
            return new StripeGateWay();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    protected $stripe = 'sk_test_uXhI2e7BY5NGtORa2uUd0mlN00QErVhUZ1';
    public function boot()
    {
        Stripe::setApiKey($this->stripe);
//        JsonResource::withoutWrapping();
    }
}
