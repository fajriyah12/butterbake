<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Location;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->take(6)
            ->get();

        $categories = Category::where('is_active', true)->get();

        // Ambil 3 produk dari 3 kategori berbeda untuk "Morning Favorites"
        // Prioritaskan slug yang ada di seeder
        $targetSlugs = [
            'almond-morning-croissant',    // kategori: breakfast
            'heritage-sourdough-loaf',     // kategori: heritage-collection
            'dark-chocolate-ganache-tart', // kategori: cakes-pastries
        ];

        $morningFavorites = Product::where('is_active', true)
            ->whereIn('slug', $targetSlugs)
            ->with('category')
            ->get()
            ->sortBy(fn($p) => array_search($p->slug, $targetSlugs))
            ->values();

        // Fallback: jika produk tersebut belum ada, ambil 1 produk per kategori
        if ($morningFavorites->count() < 3) {
            $morningFavorites = Product::where('is_active', true)
                ->where('is_featured', true)
                ->with('category')
                ->get()
                ->unique('category_id')
                ->take(3)
                ->values();
        }

        return view('home.index', compact('featuredProducts', 'categories', 'morningFavorites'));
    }

    public function about()
    {
        return view('home.about');
    }

    public function locations()
    {
        $locations = Location::where('is_active', true)->get();
        return view('home.locations', compact('locations'));
    }
}