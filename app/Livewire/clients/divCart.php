<?php

namespace App\Livewire\clients;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Colors;
use App\Models\Packageproducts;
use App\Models\Product;
use App\Models\Sections;
use App\Models\Sizes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Exception;

class divCart extends Component
{

    public $cart;
    public $items = [];
    public $quantities = [];
    public $subtotal = 0;

    public function mount()
    {
        $clientId = Auth::guard('clients')->id();

        $this->cart = Cart::with(['items.product'])
            ->where('client_id', $clientId)
            ->first();

        if ($this->cart) {
            foreach ($this->cart->items as $item) {
                $this->items[] = $item;
                $this->quantities[$item->id] = $item->qty;
            }
            $this->calculateSubtotal();
        }
    }


    public function calculateSubtotal()
    {
        $this->subtotal = collect($this->items)
            ->filter(function ($item) {
                return !$item->isOutOfStock(); // فقط المنتجات المتوفرة
            })
            ->sum(function ($item) {
                return $item->price * $item->qty;
            });
    }

    public function updateQuantity($itemId, $qty)
    {
        $item = CartItem::find($itemId);
        if (!$item) return;

        if ($item->isOutOfStock()) {
            session()->flash('error', 'Product out of stock');
            $this->quantities[$itemId] = 0;
            $item->update(['qty' => 0]);
            $this->calculateSubtotal();
            return;
        }
        $qty = min((int)$qty, $item->getAvailableStock());

        $item->update(['qty' => $qty]);
        $this->quantities[$itemId] = $qty;


        // حدّث الـ items array أيضاً (باش subtotal يحسب صح)
        foreach ($this->items as $i) {
            if ($i->id === $itemId) {
                $i->qty = $qty;
                break;
            }
        }
        $this->calculateSubtotal();
    }

    public function removeItem($itemId)
    {
        $item = CartItem::findorFail($itemId);
        if (!$item) {
            return;
        }

        // 🗑️ حذف من DB
        $item->delete();

        // 🧹 تنظيف select / quantities إن وجد
        unset($this->quantities[$itemId]);

        session()->flash('success', 'Product removed from cart');
        return redirect()->to('Cart');

    }

    public function deleteall()
    {
        DB::table('cart_items')->delete();
        session()->flash('success', 'Products removed from cart');
        return redirect()->to('Cart');
    }
    public function render()
    {
        return view('livewire.Clients.divCart');
    }
}
