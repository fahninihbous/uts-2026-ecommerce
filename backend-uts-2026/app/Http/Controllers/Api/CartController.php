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

            // Normalisasi ukuran dan warna jika kosong/null agar seragam
            $size = $request->input('size', 'All Size');
            $color = $request->input('color', 'Default');
            $incomingQty = (int) $request->input('quantity', 1);

            // Cek manual apakah item sudah ada di keranjang
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->where('size', $size)
                ->where('color', $color)
                ->first();

            if ($cartItem) {
                // Jika sudah ada, tambahkan quantity secara manual via PHP
                $cartItem->quantity += $incomingQty;
                $cartItem->save();
            } else {
                // Jika belum ada, buat baru
                $cartItem = CartItem::create([
                    'cart_id'    => $cart->id,
                    'product_id' => $request->product_id,
                    'quantity'   => $incomingQty,
                    'size'       => $size,
                    'color'      => $color,
                ]);
            }

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
