<?php

namespace App\Livewire\Dashboardumc\merchants;

use App\Models\MerchantOrder;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Refund;
use App\Services\OrderFinalNotificationService;
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
            'status'      => 'accepted',
            'accepted_at' => now(),
        ]);

        // تحديث حالة الطلب الرئيسي (مثال)
        $merchantOrder->order->update([
            'status' => 'confirmed',
        ]);

        // 🔔 إشعار نهائي (إلى كان آخر merchant)
        OrderFinalNotificationService::checkAndSend($merchantOrder->order);

        $this->loadOrders();
        session()->flash('success', 'Order accepted');
    }

    public function reject($merchantOrderId)
    {
        $merchantOrder = MerchantOrder::with('order.payment', 'order.items')
            ->where('id', $merchantOrderId)
            ->where('merchant_id', $this->merchantId)
            ->firstOrFail();

        $order   = $merchantOrder->order;
        $payment = $order->payment;

        $merchantOrder->update([
            'status' => 'rejected',
        ]);

        // 💰 Refund إلا كان مدفوع
        if ($payment && $payment->status === 'paid') {
            $amount = $order->items
                ->where('merchant_id', $merchantOrder->merchant_id)
                ->sum(fn ($item) => $item->qty * $item->price);

            if ($amount > 0) {
                $payment->update([
                    'status' => 'refunded',
                ]);

                Refund::create([
                    'order_id'     => $order->id,
                    'merchant_id'  => $merchantOrder->merchant_id,
                    'payment_id'   => $payment->id,
                    'client_id'    => $order->client_id,
                    'amount'       => $amount,
                    'reason'       => 'Merchant rejected order',
                    'status'       => $payment->method === 'cod' ? 'completed' : 'pending',
                    'processed_at' => $payment->method === 'cod' ? now() : null,
                ]);
            }
        }

        // تحديث حالة الطلب (مثال)
        $order->update([
            'status' => 'cancelled',
        ]);

        // 🔔 إشعار نهائي (إلى كان آخر merchant)
        OrderFinalNotificationService::checkAndSend($order);


        $this->loadOrders();
        session()->flash('error', 'Order rejected');
    }

    public function render()
    {
        return view('livewire.Dashboardumc.merchants.ordersmerchant');
    }
}
