<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::with('category');

        if ($request->category_id) {
            $products->where('category_id', $request->category_id);
        }

        $products = $products->latest()->paginate(10);

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'category_id'  => 'required',
            'price'        => 'required|numeric',
            'stock'        => 'required|integer',
            'image'        => 'nullable|image|mimes:jpg,png,jpeg',
            'rating'       => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'description'  => $request->description,
            'ingredients'  => $request->ingredients,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'image'        => $imagePath,
            'is_featured'  => $request->has('is_featured'),
            'is_active'    => $request->has('is_active'),
            'rating'       => $request->rating ?? 0,
            'review_count' => $request->review_count ?? 0,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'         => 'required',
            'category_id'  => 'required',
            'price'        => 'required|numeric',
            'stock'        => 'required|integer',
            'image'        => 'nullable|image|mimes:jpg,png,jpeg',
            'rating'       => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'description'  => $request->description,
            'ingredients'  => $request->ingredients,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'image'        => $product->image,
            'is_featured'  => $request->has('is_featured'),
            'is_active'    => $request->has('is_active'),
            'rating'       => $request->rating ?? $product->rating,
            'review_count' => $request->review_count ?? $product->review_count,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function updateStock(Product $product, int $qty)
   {
    $newStock = max(0, $product->stock - $qty);

    $product->update([
        'stock'     => $newStock,
        'is_active' => $newStock > 0,
    ]);
}
}