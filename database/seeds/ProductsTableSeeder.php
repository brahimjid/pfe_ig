<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
        Product::create([
            'product_name' => 'MacBook Pro',
            'product_description' => 'Apple Laptop'
        ]);

        Product::create([
            'product_name' => 'Huawei GR5 2017',
            'product_description' => 'Andriod Smart Phone'
        ]);
    }
}
