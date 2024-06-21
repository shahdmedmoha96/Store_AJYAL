<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositeries\Cart\CartModelRepositery;
use App\Repositeries\Cart\CartRepositeries;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartRepositeries $cart)
    {
        return view('front.cart', ['cart' => $cart]);
        // return view('front.cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartRepositeries $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1']
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $cart = $cart->add($product, $request->post('quantity'));
        return redirect()->route('cart.index');
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartRepositeries $cart, $id)
    {

        $request->validate([
            'quantity' => ['nullable', 'int', 'min:1']
        ]);
        $cart = $cart->updata($id, $request->post('quantity'));
        return redirect()->route('cart.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartRepositeries $cart, $id)
    {
        // dd('dd');?
        $cart->delete($id);
        return redirect()->route('cart.index');
    }
}
