<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        try {
            $wishlists = Wishlist::with(['product.images', 'product.category'])
                ->where('user_id', $request->user()->id)
                ->latest()
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Data wishlist berhasil diambil.',
                'data'    => $wishlists,
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
            ]);

            $wishlist = Wishlist::firstOrCreate([
                'user_id'    => $request->user()->id,
                'product_id' => $request->product_id,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Produk ditambahkan ke wishlist.',
                'data'    => $wishlist->load('product'),
            ], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $wishlist = Wishlist::where('id', $id)
                ->where('user_id', $request->user()->id)
                ->first();

            if (!$wishlist) {
                return response()->json(['status' => false, 'message' => 'Wishlist tidak ditemukan.'], 404);
            }

            $wishlist->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Produk dihapus dari wishlist.',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
