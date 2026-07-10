<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Main Categories
        $men = Category::create(['name' => 'Men', 'slug' => 'men']);
        $women = Category::create(['name' => 'Women', 'slug' => 'women']);

        // Sub Categories - Men
        $shirts = Category::create(['name' => 'Shirts', 'slug' => 'shirts', 'parent_id' => $men->id]);
        Category::create(['name' => 'Long Sleeve', 'slug' => 'long-sleeve', 'parent_id' => $shirts->id]);
        Category::create(['name' => 'Short Sleeve', 'slug' => 'short-sleeve', 'parent_id' => $shirts->id]);
        Category::create(['name' => 'Pants', 'slug' => 'pants', 'parent_id' => $men->id]);

        // Sub Categories - Women
        Category::create(['name' => 'Dresses', 'slug' => 'dresses', 'parent_id' => $women->id]);
        Category::create(['name' => 'Skirts', 'slug' => 'skirts', 'parent_id' => $women->id]);
    }
}