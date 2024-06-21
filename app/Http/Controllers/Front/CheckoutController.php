<?php

namespace App\Http\Controllers\front;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\OrderAdress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositeries\Cart\CartRepositeries;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepositeries $cart)
    {
        // dd(Countries::getNames());
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }
    public function store(Request $request, CartRepositeries $cart)
    {
        // dd($request->all());
        $request->validate([
            'addr.billing.first_name' => 'required|string',
            'addr.billing.last_name' => 'required|string',
            'addr.billing.email' => 'required|email',
            // 'addr.billing.street_address' => 'required|string',
            'addr.billing.phone_number' => 'required|string',
            'addr.billing.city' => 'required|string',
            // 'addr.billing.country' => 'required|string',
            // 'addr.billing.state' => 'required|string',
            'addr.shipping.first_name' => 'required|string',
            'addr.shipping.last_name' => 'required|string',
            'addr.shipping.email' => 'required|email',
            // 'addr.shipping.street_address' => 'required|string',
            'addr.shipping.phone_number' => 'required|string',
            'addr.shipping.city' => 'required|string',
            // 'addr.shipping.country' => 'required|string',
            // 'addr.shipping.state' => 'required|string',

            'shipping' => 'required|in:on',
        ]);
        $items = $cart->get()->groupBy('product.store_id');
        DB::beginTransaction(); //
        try {
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',

                ]);
                foreach ($cart_items as $item) {
                    // dd($item->product->price);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }
                foreach ($request->post('addr') as $type => $address) {
                    // dd($address['state']);
                    $state = isset($address['state']) ? $address['state'] : null;
                    $country = isset($address['country']) ? $address['country'] : null;
                    $address['type'] = $type;
                    $order->addresses()->create([
                        'type' => $address['type'],
                        'first_name' => $address['first_name'],
                        'last_name' => $address['last_name'],
                        'email' => $address['email'],
                        'phone_number' => $address['phone_number'],
                        'street_address' => $address['street_address'],
                        'city' => $address['city'],
                        'state' => $state,
                        'postal_code' => $address['postal_code'],
                        'country' => $country
                    ]);
                }
            }

            // $cart->empty();
            DB::commit();
            // event(new OrderCreated( $cart,$order) );
            event(new OrderCreated($order, $cart));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('home');
    }
}
