<?php

namespace App\Http\Controllers;

use App\Models\Regla;
use App\Models\Vendedor;
use App\Models\Venta;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    // vendedores y reglas para mostrar en pantalla
    public function index()
    {
        return response()->json([
            'vendedores' => Vendedor::all(),
            'reglas' => Regla::orderBy('umbral_monto')->get(),
        ]);
    }

    // calcula la comisión de cada vendedor en un rango de fechas
    public function calcular(Request $request)
    {
        $datos = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // las reglas se cargan una sola vez, de mayor a menor umbral
        $reglas = Regla::orderByDesc('umbral_monto')->get();

        $ventas = Venta::with('vendedor')
            ->whereBetween('fecha_venta', [$datos['fecha_inicio'], $datos['fecha_fin']])
            ->get();

        $totales = [];

        foreach ($ventas as $venta) {
            // la primera regla que la venta alcance es la de mayor umbral
            $regla = $reglas->first(fn ($r) => $venta->monto >= $r->umbral_monto);
            $porcentaje = $regla ? $regla->porcentaje : 0;
            $comision = $venta->monto * $porcentaje;

            $nombre = $venta->vendedor->nombre;
            $totales[$nombre] = ($totales[$nombre] ?? 0) + $comision;
        }

        // lo convertimos en lista para que Vue lo recorra fácil
        $resumen = [];
        foreach ($totales as $nombre => $total) {
            $resumen[] = ['vendedor' => $nombre, 'total_comision' => round($total, 2)];
        }

        return response()->json([
            'fecha_inicio' => $datos['fecha_inicio'],
            'fecha_fin' => $datos['fecha_fin'],
            'resumen' => $resumen,
        ]);
    }
}
