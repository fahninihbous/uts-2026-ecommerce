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
            $products = Product::with(['category', 'images'])
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
                'size'           => 'nullable|string|max:50',
                'color'          => 'nullable|string|max:50',
                'material'       => 'nullable|string|max:100',
                'price'          => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'stock'          => 'required|integer|min:0',
                'weight'         => 'nullable|numeric|min:0',
                'is_active'      => 'boolean',
                'is_featured'    => 'boolean',
            ]);

            $product = Product::create($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil dibuat.',
                'data'    => $product->load('category'),
            ], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $product = Product::with(['category', 'images'])->find($id);

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
}
