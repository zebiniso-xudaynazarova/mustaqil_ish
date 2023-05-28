<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Category::create(['name'=>'Badiy Kitoblar','slug'=>'Badiy Kitoblar']);
         Category::create(['name'=>'Siyosiy Kitoblar','slug'=>'Siyosiy Kitoblar']);
         Category::create(['name'=>'Ilmiy kitobar','slug'=>'Ilmiy kitobar']);
    }
}
