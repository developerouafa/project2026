<?php
// app/Services/OrderFinalNotificationService.php

namespace App\Services;

use App\Models\Order;
use App\Notifications\OrderFinalStatusNotification;
use Illuminate\Support\Facades\Notification;

class OrderFinalNotificationService
{
    // public static function checkAndSend($order)
    // {
    //     $merchants = $order->items->groupBy('merchant_id');

    //     $summary = [];
    //     $total_amount = 0;
    //     $allAccepted = true;

    //     foreach ($merchants as $merchantId => $items) {
    //         // حالة merchant الحالي: accepted أو rejected فقط
    //         $merchantStatus = $items->every(fn($item) => $item->status === 'accepted') ? 'accepted' : 'rejected';

    //         $summary[] = [
    //             'merchant_id' => $merchantId,
    //             'status' => $merchantStatus,
    //             'amount' => $items->sum('final_price'),
    //         ];

    //         $total_amount += $items->sum('final_price');

    //         if ($merchantStatus !== 'accepted') {
    //             $allAccepted = false;
    //         }
    //     }

    //     // الحالة النهائية للطلب كامل: accepted فقط إذا كل merchants قبلوا
    //     $final_status = $allAccepted ? 'accepted' : 'rejected';

    //     $message = $final_status === 'accepted'
    //         ? 'Your order has been fully accepted ✅'
    //         : 'Unfortunately, your order has been rejected ❌';

    //     $orderData = [
    //         'order_id' => $order->id,
    //         'final_status' => $final_status,
    //         'total_amount' => $total_amount,
    //         'summary' => $summary,
    //         'message' => $message,
    //     ];

    //     // إرسال Notification للزبون
    //     $order->client->notify(new \App\Notifications\OrderFinalStatusNotification($orderData));
    // }

    // 2 top
    // public static function checkAndSend($order)
    // {
    //     // كنشوفو غير الحالة النهائية ديال الطلب
    //     if (! in_array($order->status, ['confirmed', 'cancelled'])) {
    //         return;
    //     }

    //     $merchants = $order->items->groupBy('merchant_id');

    //     $summary = [];
    //     $total_amount = 0;

    //     foreach ($merchants as $merchantId => $items) {
    //         $merchantStatus = $items->every(fn ($item) => $item->status === 'accepted')
    //             ? 'accepted'
    //             : 'rejected';

    //         $summary[] = [
    //             'merchant_id' => $merchantId,
    //             'status'      => $merchantStatus,
    //             'amount'      => $items->sum('price'),
    //         ];

    //         $total_amount += $items->sum('price');
    //     }

    //     // 🔥 هنا القرار الحقيقي
    //     $final_status = $order->status === 'confirmed'
    //         ? 'accepted'
    //         : 'rejected';

    //     $message = $final_status === 'accepted'
    //         ? 'Your order has been accepted ✅'
    //         : 'Your order has been rejected ❌';

    //     $orderData = [
    //         'order_id' => $order->id,
    //         'final_status' => $final_status,
    //         'total_amount' => $total_amount,
    //         'summary' => $summary,
    //         'message' => $message,
    //     ];

    //     // إرسال Notification للزبون
    //     $order->client->notify(new \App\Notifications\OrderFinalStatusNotification($orderData));
    // }

    public static function checkAndSend($order)
    {
        // 1️⃣ خاص الطلب يكون وصل لحالة نهائية
        if (! in_array($order->status, ['confirmed', 'cancelled'])) {
            return;
        }

        // 2️⃣ نتأكدو أن كاع merchants جاوبو
        $pendingMerchants = $order->merchantOrders()
            ->where('status', 'pending')
            ->exists();

        if ($pendingMerchants) {
            // باقي شي merchant ما جاوبش → ما كاين لا notification
            return;
        }

        // 3️⃣ summary (اختياري للعرض فقط)
        $merchants = $order->items->groupBy('merchant_id');
        $summary = [];

        foreach ($merchants as $merchantId => $items) {
            $merchantStatus = $items->every(fn ($item) => $item->status === 'accepted')
                ? 'accepted'
                : 'rejected';

            $summary[] = [
                'merchant_id' => $merchantId,
                'status'      => $merchantStatus,
                'amount'      => $order->sum('total'),
            ];
        }

        // 4️⃣ الحالة النهائية مبنية فقط على order.status
        $final_status = $order->status === 'confirmed'
            ? 'accepted'
            : 'rejected';

        $message = $final_status === 'accepted'
            ? 'Your order has been accepted ✅'
            : 'Your order has been rejected ❌';

        // 5️⃣ total من orders مباشرة
        $orderData = [
            'order_id'     => $order->id,
            'final_status' => $final_status,
            'total_amount' => $order->total, // 👈 هنا
            'summary'      => $summary,
            'message'      => $message,
        ];

        // 6️⃣ إرسال Notification مرة وحدة فقط
        $order->client->notify(
            new \App\Notifications\OrderFinalStatusNotification($orderData)
        );
    }

}
