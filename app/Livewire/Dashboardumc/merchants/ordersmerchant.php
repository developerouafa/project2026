<?php

namespace App\Livewire\Dashboardumc\merchants;

use App\Models\MerchantOrder;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Refund;
use App\Services\OrderRefundService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ordersmerchant extends Component
{
    public $merchantId;
    public $orders;
    public $statusFilter = 'all'; // all | pending | accepted | rejected

    public function mount()
    {
        $this->merchantId = Auth::guard('merchants')->id();
        $this->loadOrders();
    }

    public function updatedStatusFilter()
    {
        $this->loadOrders();
    }

    protected function loadOrders()
    {
        $query = MerchantOrder::with([
            'order.client',
            'order.addresse',          // ✅ سمّيها addresse
            'order.items.product',
            'order.invoices',
        ])->where('merchant_id', $this->merchantId);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $this->orders = $query->latest()->get();
    }

    /* =========================
     * Actions
     * ========================= */

    public function accept($merchantOrderId)
    {
        $merchantOrder = MerchantOrder::where('id', $merchantOrderId)
            ->where('merchant_id', $this->merchantId)
            ->firstOrFail();

        $merchantOrder->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        // تحديث order الرئيسي
        $merchantOrder->order->update([
            'status' => 'confirmed',
        ]);

        $this->loadOrders();
        session()->flash('success', 'Order accepted');
    }

    public function reject($merchantOrderId)
    {
        // 1️⃣ جلب MerchantOrder مع order و payment
        $merchantOrder = MerchantOrder::with('order.payment', 'order.items')
            ->where('id', $merchantOrderId)
            ->where('merchant_id', $this->merchantId)
            ->firstOrFail();

        $order = $merchantOrder->order;
        $payment = $order->payment; // assuming relation: order -> payment

        // 2️⃣ تحديث حالة MerchantOrder
        $merchantOrder->update([
            'status' => 'rejected',
        ]);

        // 3️⃣ إذا الدفع مدفوع => refund + create Refund record
        if ($payment && $payment->status === 'paid') {
            // حساب مبلغ المنتجات الخاصة بهذا التاجر فقط
            $amount = $order->items
                        ->sum(fn($item) => $item->qty * $item->price);
            if ($amount > 0) {
                // تحديث حالة الدفع
                $payment->update([
                    'status' => 'refunded',
                ]);

                // إنشاء سجل Refund
                Refund::create([
                    'order_id'    => $order->id,
                    'merchant_id' => $merchantOrder->merchant_id,
                    'payment_id'  => $payment->id,
                    'client_id'   => $order->client_id,
                    'amount'      => $amount,
                    'reason'      => 'Merchant rejected order',
                    'status'      => $payment->method === 'cod' ? 'completed' : 'pending',
                    'processed_at'=> $payment->method === 'cod' ? now() : null,
                ]);
            }
        }

        // 4️⃣ تحديث حالة الطلب الرئيسي
        $order->update([
            'status' => 'cancelled',
        ]);

        $this->loadOrders();
        session()->flash('error', 'Order rejected and refunded if paid');
    }


    public function render()
    {
        return view('livewire.dashboardumc.merchants.ordersmerchant');
    }
}
