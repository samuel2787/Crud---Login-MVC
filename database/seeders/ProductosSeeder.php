<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            ['name' => 'Laptop', 'price' => 850.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mouse', 'price' => 15.50, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Teclado', 'price' => 35.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Monitor', 'price' => 180.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Audífonos', 'price' => 25.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
