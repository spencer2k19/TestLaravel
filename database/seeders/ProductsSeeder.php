<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<10;$i++)
        {
            DB::table('products')->insert([
                'name'=> "Product $i",
                'price'=> rand(10,200),
            ]);
        }
    }
}
