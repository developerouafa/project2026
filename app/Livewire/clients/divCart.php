<?php

namespace App\Livewire\clients;

use App\Models\Addresse;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Colors;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Packageproducts;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sections;
use App\Models\Sizes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class divCart extends Component
{

    public $cart;
    public $items = [];
    public $quantities = [];
    public $subtotal = 0;


    // ✅ Checkout fields
    public $name;
    public $email;
    public $phone;
    public $Addresse = [];
    public $selected_address = null;
    public $street;
    public $city;
    public $state;
    public $postal_code;
    public $country = 'Morocco';
    public $payment_method = 'cash'; // cash | stripe

    public function mount()
    {
        $clientId = Auth::guard('clients')->id();

        $this->cart = Cart::with(['items.product'])->where('client_id', $clientId)->first();

        if ($this->cart) {
            foreach ($this->cart->items as $item) {
                $this->items[] = $item;
                $this->quantities[$item->id] = $item->qty;
            }
            $this->calculateSubtotal();
        }

        $client = Auth::guard('clients')->user();
        $this->name  = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;

        // عناوين الزبون
        $this->Addresse = $client->Addresse()->get();
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

    // ✅ اختيار عنوان موجود
    public function updatedSelectedAddress($addressId)
    {
        $address = Addresse::find($addressId);
        if ($address) {
            $this->street      = $address->street;
            $this->city        = $address->city;
            $this->state       = $address->state;
            $this->postal_code = $address->postal_code;
            $this->country     = $address->country;
        }
    }

    // ✅ Checkout بدون بوابة دفع
    public function checkout()
    {
        $this->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'street'  => 'required|string',
            'city'    => 'required|string',
            'country' => 'required|string',
            'payment_method' => 'required|in:cash,stripe',
        ]);

        if (empty($this->items)) {
            session()->flash('error', 'Cart is empty');
            return;
        }

        DB::beginTransaction();

        try {

            $client = Auth::guard('clients')->user();

            /* =========================
            * 1️⃣ Address
            * ========================= */
            $address = Addresse::create([
                'client_id'   => $client->id,
                'title'       => 'Checkout',
                'street'      => $this->street,
                'city'        => $this->city,
                'state'       => $this->state,
                'postal_code' => $this->postal_code,
                'country'     => $this->country,
                'phone'       => $this->phone,
                'default'     => false,
            ]);

            /* =========================
            * 2️⃣ Order
            * ========================= */
            $order = Order::create([
                'client_id'   => $client->id,
                'merchant_id' => $this->items[0]->product->merchant_id, // فرضاً cart لتاجر واحد
                'total'       => $this->subtotal,
                'status'      => $this->payment_method === 'cash'
                                    ? 'pending'
                                    : 'pending', // paid من بعد Stripe webhook
            ]);

            /* =========================
            * 3️⃣ Order Items
            * ========================= */

            foreach ($this->items as $item) {

                $orderitem = OrderItem::create([
                    'order_id'          => $order->id,
                    'product_id'        => $item->product_id,
                    'color'             => $item->color,
                    'size'              => $item->size,
                    'qty'               => $item->qty,
                    'price'             => $item->price,
                ]);
            }
            /* =========================
            * 4️⃣ Payment
            * ========================= */
            $reference = (string) Str::uuid();

            $payment = Payment::create([
                'date'        => now(),
                'client_id'   => $client->id,
                'amount'      => $this->subtotal,
                'method'      => $this->payment_method,
                'status'      => $this->payment_method === 'cash'
                                    ? 'pending'   // COD
                                    : 'pending',  // Stripe (حتى يخلص)
                'reference'   => $reference,
                'description' => 'Order #' . $order->id,
            ]);

            /* =========================
            * 5️⃣ Stripe case
            * ========================= */

            if ($this->payment_method === 'stripe') {

                Stripe::setApiKey(config('services.stripe.secret'));

                $session = \Stripe\Checkout\Session::create([
                    'mode' => 'payment',
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Order #' . $order->id,
                            ],
                            'unit_amount' => $payment->amount * 100,
                        ],
                        'quantity' => 1,
                    ]],
                    'success_url' => route('checkout.success'),
                    'cancel_url'  => route('checkout.cancel'),
                    'metadata' => [
                        'order_id'  => (string) $order->id,
                        'reference' => (string) $reference, // ✅ نفس القيمة
                    ],
                ]);
                        // start dertha hena blast controllerhit makatkhedmch khas api webhook https ha9i9i
                                        $payment = Payment::where('reference', $reference)->first();
                                        if (!$payment) {
                                            return response()->json(['error' => 'Payment not found'], 404);
                                        }

                                        $payment->update([
                                            'status'    => 'paid',
                                            'stripe_id' => 'order'+'created_at'+$reference,
                                            'pm_type'   => 'card',
                                        ]);

                                        Order::where('id', $order->id)->update(['status' => 'paid']);
                        // end
                DB::commit();

                // ✅ هادي هي redirect الصحيحة
                return redirect()->away($session->url);
            }

            /* =========================
            * 6️⃣ COD case
            * ========================= */
            DB::table('cart_items')->where('cart_id', $this->cart->id)->delete();
            $this->cart->delete();

            DB::commit();

            session()->flash('success', 'Order confirmed (Cash on Delivery)');
            return redirect()->route('Cart');
            // return redirect()->route('client.orders.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Checkout failed');
        }
    }

    public function render()
    {
        return view('livewire.Clients.divCart');
    }
}
