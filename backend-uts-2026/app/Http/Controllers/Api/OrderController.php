<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $orders = Order::with(['items.product', 'payment'])
                ->where('user_id', $request->user()->id)
                ->latest()
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Daftar pesanan berhasil diambil.',
                'data'    => $orders,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|max:255',
                'phone'         => 'required|string|max:30',
                'address'       => 'required|string',
                'city'          => 'required|string|max:100',
                'state'         => 'required|string|max:100',
                'postal_code'   => 'required|string|max:20',
                'shipping_cost' => 'required|numeric|min:0',
            ]);

            $user = $request->user();
            $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

            if (!$cart || $cart->items->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Keranjang belanja kosong.'], 400);
            }

            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                $totalAmount += $price * $item->quantity;
            }

            $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->postal_code;

            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'ORD-' . date('Ymd') . '-' . rand(1000, 9999),
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'shipping_name'    => $request->name,
                'shipping_address' => $fullAddress,
                'shipping_phone'   => $request->phone,
                'total_amount'     => $totalAmount + $request->shipping_cost,
                'shipping_cost'    => $request->shipping_cost,
            ]);

            foreach ($cart->items as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'size'         => $item->size,
                    'color'        => $item->color,
                    'quantity'     => $item->quantity,
                    'price'        => $price,
                    'subtotal'     => $price * $item->quantity,
                ]);
            }

            $cart->items()->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Pesanan berhasil dibuat.',
                'data'    => $order->load('items'),
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $order = Order::with(['items.product.images', 'payment'])
                ->where('id', $id)
                ->where('user_id', $request->user()->id)
                ->first();

            if (!$order) {
                return response()->json(['status' => false, 'message' => 'Pesanan tidak ditemukan.'], 404);
            }

            return response()->json([
                'status' => true,
                'data'   => $order,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
