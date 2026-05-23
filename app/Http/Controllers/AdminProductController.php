<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::with('category');

        // FILTER CATEGORY
        if ($request->category_id) {
            $products->where('category_id', $request->category_id);
        }

        $products = $products->latest()->paginate(10);

        return view('admin.products.index', compact(
            'products',
            'categories'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required',
            'price'        => 'required|numeric',
            'stock'        => 'required|integer',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png',
            'rating'       => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
        ]);

        $imagePath = null;

        // UPLOAD IMAGE
        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');
        }

        // CREATE PRODUCT
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

        return redirect()
            ->route('admin.products.index')
            ->with([
                'success' => true,
                'title'   => 'Product Saved Successfully',
                'message' => $request->name . ' has been added to inventory.'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact(
            'product',
            'categories'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required',
            'price'        => 'required|numeric',
            'stock'        => 'required|integer',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png',
            'rating'       => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
        ]);

        // UPDATE IMAGE
        if ($request->hasFile('image')) {

            // DELETE OLD IMAGE
            if ($product->image) {

                Storage::disk('public')
                    ->delete($product->image);
            }

            $product->image = $request
                ->file('image')
                ->store('products', 'public');
        }

        // UPDATE PRODUCT
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

        return redirect()
            ->route('admin.products.index')
            ->with([
                'success' => true,
                'title'   => 'Product Updated',
                'message' => $request->name . ' has been updated successfully.'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    // SESUDAH
public function destroy(Product $product)
{
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()
        ->route('admin.products.index')
        ->with([
            'delete' => true,         // ← ganti 'success' jadi 'delete'
            'title'   => 'Product Deleted',
            'message' => $product->name . ' has been removed from inventory.'
        ]);
}
    /*
    |--------------------------------------------------------------------------
    | UPDATE STOCK
    |--------------------------------------------------------------------------
    */
    public function updateStock(Product $product, int $qty)
    {
        $newStock = max(0, $product->stock - $qty);

        $product->update([
            'stock' => $newStock,
        ]);
    }
}