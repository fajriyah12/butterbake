<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $heritage    = Category::where('slug', 'heritage-collection')->first();
        $breakfast   = Category::where('slug', 'breakfast')->first();
        $cakes       = Category::where('slug', 'cakes-pastries')->first();
        $bread       = Category::where('slug', 'artisan-bread')->first();
        $croissants  = Category::where('slug', 'croissants')->first();

        $products = [
            // Heritage Collection
            [
                'category_id' => $heritage->id,
                'name'        => 'Velvet Truffle Cake',
                'slug'        => 'velvet-truffle-cake',
                'description' => 'Kue velvet mewah berlapis truffle cokelat premium dengan tekstur lembut dan kaya rasa.',
                'ingredients' => 'Tepung terigu, cokelat truffle premium, telur segar, mentega, gula, krim.',
                'price'       => 185000,
                'stock'       => 20,
                'is_featured' => true,
                'rating'      => 4.9,
                'review_count'=> 128,
            ],
            [
                'category_id' => $heritage->id,
                'name'        => 'Heritage Sourdough Loaf',
                'slug'        => 'heritage-sourdough-loaf',
                'description' => 'Roti sourdough klasik dengan starter berumur 10 tahun, kulit renyah dan dalam yang kenyal.',
                'ingredients' => 'Tepung terigu organik, air, garam, starter sourdough.',
                'price'       => 75000,
                'stock'       => 30,
                'is_featured' => true,
                'rating'      => 4.8,
                'review_count'=> 95,
            ],
            [
                'category_id' => $heritage->id,
                'name'        => 'Cinnamon Heritage Roll',
                'slug'        => 'cinnamon-heritage-roll',
                'description' => 'Roti gulung kayu manis dengan glasir vanilla yang membawa nostalgia kampung halaman.',
                'ingredients' => 'Tepung, kayu manis, gula, mentega, susu, vanila.',
                'price'       => 45000,
                'stock'       => 40,
                'is_featured' => true,
                'rating'      => 4.7,
                'review_count'=> 87,
            ],
            // Breakfast
            [
                'category_id' => $breakfast->id,
                'name'        => 'Almond Morning Croissant',
                'slug'        => 'almond-morning-croissant',
                'description' => 'Croissant renyah berlapis krim almond, sempurna untuk mengawali hari.',
                'ingredients' => 'Tepung, mentega, krim almond, gula bubuk.',
                'price'       => 38000,
                'stock'       => 50,
                'is_featured' => true,
                'rating'      => 4.8,
                'review_count'=> 112,
            ],
            [
                'category_id' => $breakfast->id,
                'name'        => 'Blueberry Danish',
                'slug'        => 'blueberry-danish',
                'description' => 'Danish segar dengan isian blueberry dan krim keju yang lembut.',
                'ingredients' => 'Pastry dough, blueberry segar, cream cheese, gula.',
                'price'       => 42000,
                'stock'       => 35,
                'is_featured' => false,
                'rating'      => 4.6,
                'review_count'=> 64,
            ],
            // Cakes
            [
                'category_id' => $cakes->id,
                'name'        => 'Strawberry Chiffon Cake',
                'slug'        => 'strawberry-chiffon-cake',
                'description' => 'Kue chiffon lembut dengan topping strawberry segar dan krim whip.',
                'ingredients' => 'Telur, tepung cake, strawberry, krim, gula.',
                'price'       => 145000,
                'stock'       => 15,
                'is_featured' => true,
                'rating'      => 4.9,
                'review_count'=> 76,
            ],
            [
                'category_id' => $cakes->id,
                'name'        => 'Dark Chocolate Ganache Tart',
                'slug'        => 'dark-chocolate-ganache-tart',
                'description' => 'Tart cokelat hitam dengan ganache tebal dan sea salt flakes di atasnya.',
                'ingredients' => 'Cokelat dark 70%, krim, mentega, shortcrust pastry, garam laut.',
                'price'       => 95000,
                'stock'       => 25,
                'is_featured' => false,
                'rating'      => 4.8,
                'review_count'=> 58,
            ],
            // Artisan Bread
            [
                'category_id' => $bread->id,
                'name'        => 'Rosemary Focaccia',
                'slug'        => 'rosemary-focaccia',
                'description' => 'Focaccia Italia dengan rosemary segar, minyak zaitun extra virgin, dan garam fleur de sel.',
                'ingredients' => 'Tepung terigu, ragi, minyak zaitun, rosemary, garam.',
                'price'       => 65000,
                'stock'       => 20,
                'is_featured' => false,
                'rating'      => 4.7,
                'review_count'=> 43,
            ],
            // Croissants
            [
                'category_id' => $croissants->id,
                'name'        => 'Classic Butter Croissant',
                'slug'        => 'classic-butter-croissant',
                'description' => 'Croissant mentega klasik dengan 81 lapisan, tekstur ringan dan renyah di luar.',
                'ingredients' => 'Tepung terigu, mentega premium, susu, ragi, gula, garam.',
                'price'       => 32000,
                'stock'       => 60,
                'is_featured' => false,
                'rating'      => 4.9,
                'review_count'=> 210,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['slug' => $product['slug']], $product);
        }
    }
}