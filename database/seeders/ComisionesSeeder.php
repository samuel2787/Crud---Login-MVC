<?php

namespace Database\Seeders;

use App\Models\Regla;
use App\Models\Vendedor;
use App\Models\Venta;
use Illuminate\Database\Seeder;

class ComisionesSeeder extends Seeder
{
    public function run(): void
    {
        Vendedor::insert([
            ['nombre' => 'Jossue Ayala', 'email' => 'jossue.ayala@udla.edu.ec', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Melanie Jacome', 'email' => 'melanie.jacome@udla.edu.ec', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Carlos Pérez', 'email' => 'carlos.perez@udla.edu.ec', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'María Ortiz', 'email' => 'maria.ortiz@udla.edu.ec', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Regla::insert([
            ['porcentaje' => 0.00, 'umbral_monto' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['porcentaje' => 0.06, 'umbral_monto' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['porcentaje' => 0.08, 'umbral_monto' => 600, 'created_at' => now(), 'updated_at' => now()],
            ['porcentaje' => 0.10, 'umbral_monto' => 800, 'created_at' => now(), 'updated_at' => now()],
            ['porcentaje' => 0.15, 'umbral_monto' => 1000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Venta::insert([
            ['vendedor_id' => 1, 'fecha_venta' => '2025-06-02', 'monto' => 650, 'created_at' => now(), 'updated_at' => now()],
            ['vendedor_id' => 1, 'fecha_venta' => '2025-06-15', 'monto' => 850, 'created_at' => now(), 'updated_at' => now()],
            ['vendedor_id' => 2, 'fecha_venta' => '2025-06-05', 'monto' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['vendedor_id' => 2, 'fecha_venta' => '2025-06-20', 'monto' => 1200, 'created_at' => now(), 'updated_at' => now()],
            ['vendedor_id' => 3, 'fecha_venta' => '2025-06-10', 'monto' => 300, 'created_at' => now(), 'updated_at' => now()],
            ['vendedor_id' => 4, 'fecha_venta' => '2025-06-12', 'monto' => 900, 'created_at' => now(), 'updated_at' => now()],
            ['vendedor_id' => 4, 'fecha_venta' => '2025-05-28', 'monto' => 700, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
