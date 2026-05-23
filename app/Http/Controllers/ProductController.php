<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true);

        /*
        |--------------------------------------------------------------------------
        | FILTER CATEGORY
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH PRODUCT
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | PRICE RANGE
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */
        switch ($request->get('sort', 'newest')) {

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'rating':
                $query->orderBy('rating', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | GET PRODUCTS
        |--------------------------------------------------------------------------
        */
        $products = $query->paginate(6)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | GET CATEGORIES
        |--------------------------------------------------------------------------
        */
        $categories = Category::where('is_active', true)->get();

        return view('products.katalog', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'category',
                'reviews.user'
            ])
            ->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.detail', compact('product', 'related'));
    }
}