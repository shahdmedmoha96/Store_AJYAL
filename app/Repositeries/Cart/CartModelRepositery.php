<?php

namespace App\Repositeries\Cart;

use App\Models\Cart;
use app\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class  CartModelRepositery implements CartRepositeries
{
    public function get(): Collection
    {
        return Cart::with('product')->get();
    }
    public function add(Product $product, $quantity = 1)
    {
        $item =  Cart::where('product_id', '=', $product->id)->first();
        if (!$item) {
            return  Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }
        return $item->increment('quantity', $quantity);
    }

    public function updata($id, $quantity)
    {
        Cart::where('product_id', '=', $id)
            ->update([
                'quantity' => $quantity,
            ]);
    }
    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->delete();
    }
    public function empty()
    {
        Cart::query()->delete();
    }
    public function total(): float
    {
        return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total');
    }
}
