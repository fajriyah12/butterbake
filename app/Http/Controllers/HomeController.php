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

    // Morning Favorites
    $morningFavorites = Product::where('is_active', true)
        ->latest()
        ->take(3)
        ->get();

    return view('home.index', compact(
        'featuredProducts',
        'categories',
        'morningFavorites'
    ));
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