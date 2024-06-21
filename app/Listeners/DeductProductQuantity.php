<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle()
    {
        try {

            foreach (Cart::get() as $item) {
                Product::where('id', $item->product_id)
                    ->update(['quantity' => DB::raw("quantity - $item->quantity")]);

                //    dd($product->quantity ,$item->product_id);

            }
        } catch (Throwable $e) {
        }
    }
}
