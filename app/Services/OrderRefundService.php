<?php
namespace App\Services;

use App\Models\MerchantOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;

use Stripe\Stripe;
use Stripe\Refund as StripeRefund;

class OrderRefundService
{
    /**
     * Refund partial or full amount via Stripe
     */
    public function stripeRefund(Payment $payment, Refund $refund)
    {
        if ($payment->method !== 'stripe') {
            return false; // ماشي Stripe
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $stripeRefund = StripeRefund::create([
                'payment_intent' => $payment->stripe_id,       // Stripe Payment Intent ID
                'amount'         => intval($refund->amount * 100), // cents
                'metadata'       => [
                    'refund_id' => $refund->id,
                    'order_id'  => $payment->order_id ?? null,
                    'merchant_id' => $refund->merchant_id,
                ],
            ]);

            // تم إنشاء refund بنجاح، يبقى pending حتى يجي webhook
            return $stripeRefund;

        } catch (\Exception $e) {
            \Log::error("Stripe refund failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle refund creation logic
     */
    public function createRefund($order, $merchantOrder, $payment)
    {
        // فقط المنتجات ديال هاد التاجر و مازال ما تدارش ليهم refund
        $items = $order->items->where('merchant_id', $merchantOrder->merchant_id)
                              ->whereNull('refunded_at');

        $amount = $items->sum(fn ($item) => $item->qty * $item->price);

        if ($amount <= 0) return null;

        $refund = Refund::create([
            'order_id'    => $order->id,
            'merchant_id' => $merchantOrder->merchant_id,
            'payment_id'  => $payment->id,
            'client_id'   => $order->client_id,
            'amount'      => $amount,
            'reason'      => 'Merchant rejected order',
            'status'      => $payment->method === 'stripe' ? 'pending' : 'completed',
            'processed_at'=> $payment->method === 'cod' ? now() : null,
        ]);

        // Update refunded_at on order items
        foreach ($items as $item) {
            $item->update(['refunded_at' => now()]);
        }

        // Stripe refund
        if ($payment->method === 'stripe') {
            $this->stripeRefund($payment, $refund);
        }

        return $refund;
    }
}

