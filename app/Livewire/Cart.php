<?php

namespace App\Livewire;


use Livewire\Component;

class Cart extends Component
{

    public $carts;
    public $grandTotal;
    public $totalTax;


    protected $listeners = ['cartUpdated' => 'mount'];

    public function mount()
    {
        $user = auth()->user();
        $this->carts = $user->carts;
        $this->calculateTotals();
    }

    public function increaseQuantity($cartId)
    {
        $cart = \App\Models\Cart::find($cartId);
        $cart->quantity += 1;
        $cart->save();
        $this->mount();
        return $this->dispatch('toast', message: 'Quantity increased successfully.', notify:'success' );

    }

    public function decreaseQuantity($cartId)
    {
        $cart = \App\Models\Cart::find($cartId);
        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
            $cart->save();
            $this->mount();
        }
        return $this->dispatch('toast', message: 'Quantity decreased successfully.', notify:'success' );
    }

    public function removeItem($cartId)
    {
        \App\Models\Cart::find($cartId)->delete();
        $this->mount();
    }



    public function calculateTotals()
    {
        $this->grandTotal = calculateSubTotalCart($this->carts);
    }




    public function render()
    {
        return view('livewire.cart');
    }

}
