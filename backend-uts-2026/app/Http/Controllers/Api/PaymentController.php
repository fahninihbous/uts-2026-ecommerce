<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        try {
            $serverKey = config('services.midtrans.server_key');
            $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashedKey !== $request->signature_key) {
                return response()->json(['status' => false, 'message' => 'Invalid signature key.'], 403);
            }

            $transactionStatus = $request->transaction_status;
            $orderId           = $request->order_id;

            // Cari data pesanan berdasarkan order_number
            $order = Order::where('order_number', $orderId)->first();
            if (!$order) {
                return response()->json(['status' => false, 'message' => 'Pesanan tidak ditemukan.'], 404);
            }

            $paymentStatus = 'pending';
            $orderStatus   = 'pending';

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $paymentStatus = 'paid';
                $orderStatus   = 'processing';
            } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $paymentStatus = 'failed';
                $orderStatus   = 'cancelled';
            }

            $order->update([
                'status'         => $orderStatus,
                'payment_status' => $paymentStatus,
            ]);

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'midtrans_transaction_id' => $request->transaction_id,
                    'midtrans_order_id'       => $request->order_id,
                    'payment_type'            => $request->payment_type,
                    'status'                  => ($paymentStatus == 'paid') ? 'success' : 'failed',
                    'gross_amount'            => $request->gross_amount,
                    'paid_at'                 => ($paymentStatus == 'paid') ? now() : null,
                    'raw_response'            => $request->all(),
                ]
            );

            return response()->json(['status' => true, 'message' => 'Callback berhasil diproses.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
