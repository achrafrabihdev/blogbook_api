<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect(['Travel', 'Science', 'Games', 'Cars', 'Books', 'News', 'Training']);

        $categories->each(function($category){
            $myCat = new Category();
            $myCat->name = $category;
            $myCat->save();
        });
    }
}
