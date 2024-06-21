<?php

namespace App\Repositeries\Cart;

use app\Models\Product;
use Illuminate\Support\Collection;

interface CartRepositeries
{
    public function get(): Collection;
    public function add(Product $product);
    public function updata($id, $quantity);
    public function delete($id);
    public function empty();
    public function total(): float;
}
