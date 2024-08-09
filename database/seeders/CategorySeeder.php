<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'sprots', 'desc' => 'sprots category', 'image' => 'football.jpg'],
            ['name' => 'technology', 'desc' => 'technology  category', 'image' => 'technology.jpg'],
            ['name' => 'clothes', 'desc' => 'clothes category', 'image' => 'clothes.jpg'],
            ['name' => 'shoses', 'desc' => 'shoses category', 'image' => 'shoses.jpg'],
        ];

        foreach ($categories as $category) {
            CategoryProduct::create($category);
        }
    }
}
