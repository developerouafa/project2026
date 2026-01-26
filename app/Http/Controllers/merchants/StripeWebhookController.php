<?php

namespace App\Http\Controllers\merchants;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig     = $request->header('Stripe-Signature');

        $event = \Stripe\Webhook::constructEvent(
            $payload,
            $sig,
            config('services.stripe.webhook_secret')
        );

        if ($event->type === 'charge.refunded') {
            $this->handleRefund($event->data->object);
        }

        return response()->json(['status' => 'ok']);
    }

    protected function handleRefund($charge)
    {
        $refundId = $charge->refunds->data[0]->metadata->refund_id ?? null;

        if (!$refundId) {
            return;
        }

        Refund::where('id', $refundId)
            ->update([
                'status' => 'completed',
                'processed_at' => now(),
            ]);
    }
}
