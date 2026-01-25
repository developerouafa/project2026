<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $reference = $session->metadata->reference ?? null;
            $orderId   = $session->metadata->order_id ?? null;

            if (!$reference || !$orderId) {
                return response()->json(['error' => 'Missing metadata'], 400);
            }

            $payment = Payment::where('reference', $reference)->first();
            if (!$payment) {
                return response()->json(['error' => 'Payment not found'], 404);
            }

            $payment->update([
                'status'    => 'paid',
                'stripe_id' => $session->payment_intent,
                'pm_type'   => 'card',
            ]);

            Order::where('id', $orderId)->update(['status' => 'paid']);
        }

        return response('Webhook handled', 200);
    }
}
