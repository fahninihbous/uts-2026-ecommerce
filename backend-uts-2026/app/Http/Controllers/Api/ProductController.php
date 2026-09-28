<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function transformProduct($product)
    {
        if ($product->relationLoaded('images')) {
            $product->images->transform(function ($img) {
                $img->image_url = asset('storage/' .$img->image_path);
                return $img;
            });
        }
        return $product;
    }

    public function index(Request $request)
    {
        try {
            $products = Product::with(['category', 'images'])
                ->latest()
                ->get();

            $products->each(fn($p) => $this->transformProduct($p));

            return response()->json([
                'status'  => true,
                'message' => 'Daftar produk berhasil diambil.',
                'data'    => $products,             ], 200);         } catch (Exception$e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated =$request->validate([
                'category_id'    => 'required|exists:categories,id',
                'name'           => 'required|string|max:255',
                'slug'           => 'required|string|unique:products,slug',
                'description'    => 'nullable|string',
                'price'          => 'required|numeric|min:0',
                'stock'          => 'required|integer|min:0',
                'is_active'      => 'boolean',
                'images.*'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file foto
            ]);

            $product = Product::create($validated);

            // Handle Multiple Image Upload
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index =>$file) {
                    $path =$file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0, // Foto pertama otomatis jadi foto utama
                        'sort_order' => $index,
                    ]);
                }
            }

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil dibuat.',
                'data'    => $this->transformProduct($product->load(['category', 'images'])),             ], 201);         } catch (\Exception$e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Produk tidak ditemukan.'
                ], 404);
            }

            $validated =$request->validate([
                'category_id'    => 'required|exists:categories,id',
                'name'           => 'required|string|max:255',
                'slug'           => 'required|string|unique:products,slug,' . $id,
                'description'    => 'nullable|string',
                'price'          => 'required|numeric|min:0',
                'stock'          => 'required|integer|min:0',
                'is_active'      => 'boolean',
                'images.*'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $product->update($validated);

            // Jika ada foto baru yang diunggah saat edit
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index =>$file) {
                    $path =$file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => false,
                        'sort_order' => $product->images()->count() +$index,
                    ]);
                }
            }

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil diperbarui.',
                'data'    => $this->transformProduct($product->load(['category', 'images'])),             ], 200);         } catch (\Exception$e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with(['category', 'images'])->find($id);

            if (!$product) {
                return response()->json(['status' => false, 'message' => 'Produk tidak ditemukan.'], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Detail produk berhasil diambil.',
                'data'   => $this->transformProduct($product),             ], 200);         } catch (Exception$e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::with('images')->find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Produk tidak ditemukan.'
                ], 404);
            }

            // Hapus file fisik dari storage
            foreach ($product->images as$img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
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
