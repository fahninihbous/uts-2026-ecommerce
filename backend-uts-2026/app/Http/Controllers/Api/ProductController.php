<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Hapus 'images' dari with() karena belum ada relasinya
            $products = Product::with(['category'])
                ->where('is_active', true)
                ->latest()
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Daftar produk berhasil diambil.',
                'data'    => $products,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id'    => 'required|exists:categories,id',
                'name'           => 'required|string|max:255',
                'slug'           => 'required|string|unique:products,slug',
                'description'    => 'nullable|string',
                'price'          => 'required|numeric|min:0',
                'stock'          => 'required|integer|min:0',
                'is_active'      => 'boolean',
            ]);

            $product = Product::create($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil dibuat.',
                'data'    => $product->load('category'),
            ], 201);
        } catch (\Exception $e) { // Menggunakan \Exception agar tidak error class not found
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Produk tidak ditemukan.'
                ], 404);
            }

            $validated = $request->validate([
                'category_id'    => 'required|exists:categories,id',
                'name'           => 'required|string|max:255',
                // Ignore slug untuk produk yang sedang diedit agar tidak error unique
                'slug'           => 'required|string|unique:products,slug,' . $id,
                'description'    => 'nullable|string',
                'price'          => 'required|numeric|min:0',
                'stock'          => 'required|integer|min:0',
                'is_active'      => 'boolean',
            ]);

            $product->update($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil diperbarui.',
                'data'    => $product->load('category'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            // Hapus 'images' dari with() di sini juga
            $product = Product::with(['category'])->find($id);

            if (!$product) {
                return response()->json(['status' => false, 'message' => 'Produk tidak ditemukan.'], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Detail produk berhasil diambil.',
                'data'   => $product,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Produk tidak ditemukan.'
                ], 404);
            }

            $product->delete();

            return response()->json([
                'status' => true,
                'message' => 'Produk berhasil dihapus.',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus produk: ' . $e->getMessage()
            ], 500);
        }
    }
}
