<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cart = Cart::with(['items.product.images'])
                ->where('user_id', $request->user()->id)
                ->first();

            return response()->json([
                'status'  => true,
                'message' => 'Data keranjang berhasil diambil.',
                'data'    => $cart ? $cart : ['items' => []],
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity'   => 'required|integer|min:1',
                'size'       => 'nullable|string|max:50',
                'color'      => 'nullable|string|max:50',
            ]);

            $cart = Cart::firstOrCreate([
                'user_id' => $request->user()->id,
            ]);

            $cartItem = CartItem::updateOrCreate(
                [
                    'cart_id'    => $cart->id,
                    'product_id' => $request->product_id,
                    'size'       => $request->size,
                    'color'      => $request->color,
                ],
                [
                    'quantity'   => \Illuminate\Support\Facades\DB::raw('quantity + ' . $request->quantity),
                ]
            );

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang.',
                'data'    => $cart->load(['items.product.images']),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $item = CartItem::find($id);
            if (!$item) {
                return response()->json(['status' => false, 'message' => 'Item keranjang tidak ditemukan.'], 404);
            }

            $item->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Item keranjang berhasil dihapus.',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
