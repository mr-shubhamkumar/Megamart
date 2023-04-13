<?php

namespace App\View\Components\Product;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card1 extends Component
{
    /**
     * Create a new component instance.
     */
    public  $products ;
    public function __construct($products)
    {
        $this->products=$products;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product.card');
    }
}
