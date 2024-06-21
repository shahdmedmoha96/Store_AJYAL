<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;
    protected $fillable = [
        'store_id',
        'user_id',
        'payment_method',
        'status',
        'payment_status',
    ];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->withPivot([
                'product_name',
                'price',
                'quanitity',
                'options',
            ]);
    }
    public function addresses()
    {
        return $this->hasMany(OrderAdress::class);
    }
    public function billingAddresses()
    {
        return  $this->hasOne(OrderAdress::class, 'order_id', 'id')
            ->where('type', '=', 'billing');
    }
    public function shippingAddresses()
    {
        return  $this->hasOne(OrderAdress::class, 'order_id', 'id')
            ->where('type', '=', 'shipping');
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            // Generate a unique order number
            $order->number = Order::getnextordernumber();
        });
    }
    protected static function getnextordernumber()
    {

        $currentYear = date('Y');

        // Find the latest order number for the current year
        $number = Order::whereYear('created_at', $currentYear)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $currentYear . '0001';
    }
}
