<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repositeries\Cart\CartRepositeries;

class CartMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $items;
    public $total;
    public function __construct(CartRepositeries $cartRepositeries)
    {

        $this->items=$cartRepositeries->get();
        $this->total=$cartRepositeries->total();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu');
    }
}
