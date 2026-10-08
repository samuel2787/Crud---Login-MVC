<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // READ: listar todos los productos
    public function index()
    {
        return Product::all();
    }

    // CREATE: crear un producto
    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        return Product::create($datos);
    }

    // UPDATE: editar un producto
    public function update(Request $request, Product $product)
    {
        $datos = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->update($datos);
        return $product;
    }

    // DELETE: eliminar un producto
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['mensaje' => 'Producto eliminado']);
    }
}