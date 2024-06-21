<?php

namespace App\Providers;

use App\Repositeries\Cart\CartModelRepositery;
use App\Repositeries\Cart\CartRepositeries;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartRepositeries::class, function(){
            return new CartModelRepositery;
        } );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
