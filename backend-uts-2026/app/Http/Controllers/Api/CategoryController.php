<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::withCount('products')->latest()->get();

            // Ubah path gambar agar menjadi URL yang bisa diakses publik
            $categories->transform(function ($category) {
                if ($category->image) {
                    $category->image_url = asset('storage/' . $category->image);
                } else {
                    $category->image_url = null;
                }
                return $category;
            });

            return response()->json([
                'status'  => true,
                'message' => 'Data kategori berhasil diambil.',
                'data'    => $categories,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:100|unique:categories,name',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar max 2MB
                'is_active'   => 'boolean',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
            }

            $category = Category::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'image'       => $imagePath,
                'is_active'   => $request->is_active ?? true,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Kategori berhasil ditambahkan.',
                'data'    => $category,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['status' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
            }

            $request->validate([
                'name'        => 'required|string|max:100|unique:categories,name,' . $id,
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active'   => 'boolean',
            ]);

            $imagePath = $category->image;
            if ($request->hasFile('image')) {
                // Hapus foto lama jika ada
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }
                $imagePath = $request->file('image')->store('categories', 'public');
            }

            $category->update([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'image'       => $imagePath,
                'is_active'   => $request->is_active ?? $category->is_active,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Kategori berhasil diperbarui.',
                'data'    => $category,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['status' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
            }

            // Hapus file foto dari storage saat kategori dihapus
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Kategori berhasil dihapus.',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
