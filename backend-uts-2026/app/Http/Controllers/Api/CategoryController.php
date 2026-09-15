<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::withCount('products')->latest()->get();

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
                'image'       => 'nullable|string',
                'is_active'   => 'boolean',
            ]);

            $category = Category::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'image'       => $request->image,
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

    public function show($id)
    {
        try {
            $category = Category::with('products')->find($id);

            if (!$category) {
                return response()->json(['status' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
            }

            return response()->json([
                'status' => true,
                'data'   => $category,
            ], 200);
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
                'image'       => 'nullable|string',
                'is_active'   => 'boolean',
            ]);

            $category->update([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'image'       => $request->image,
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
