<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Heritage Collection', 'slug' => 'heritage-collection', 'description' => 'Koleksi roti dan kue tradisional warisan leluhur.'],
            ['name' => 'Breakfast',            'slug' => 'breakfast',           'description' => 'Pilihan sarapan pagi yang lezat dan bergizi.'],
            ['name' => 'Cakes & Pastries',     'slug' => 'cakes-pastries',      'description' => 'Kue-kue istimewa untuk berbagai momen spesial.'],
            ['name' => 'Artisan Bread',         'slug' => 'artisan-bread',       'description' => 'Roti artisan yang dipanggang setiap hari.'],
            ['name' => 'Croissants',            'slug' => 'croissants',          'description' => 'Croissant lembut dengan lapisan sempurna.'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}