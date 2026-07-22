<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        // 1. Iniciamos la consulta base con la tabla correcta
        $query = DB::table('productos_farma');

        // 2. Filtro de búsqueda por nombre o ID del producto
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . $busqueda . '%')
                  ->orWhere('idProducto', 'like', '%' . $busqueda . '%');
            });
        }

        // 3. Filtro por cantidad de stock disponible
        if ($request->filled('stock')) {
            if ($request->stock == 'bajo') {
                $query->where('stockDisponible', '<', 20);
            } elseif ($request->stock == 'suficiente') {
                $query->where('stockDisponible', '>=', 20);
            }
        }

        // 4. Ejecutamos la consulta ordenada por los más recientes
        $productos = $query->orderBy('idProducto', 'desc')->get();

        return view('admin.inventario', compact('productos'));
    }

    // Muestra el formulario para crear un producto
    public function create()
    {
        return view('admin.inventario_form');
    }

    public function store(Request $request)
    {
        $nuevoId = 'PROD-' . strtoupper(substr(uniqid(), -5));

        DB::table('productos_farma')->insert([
            'idProducto'           => $nuevoId,
            'nombre'               => $request->nombre,
            'concentracionCBD_THC' => $request->concentracionCBD_THC,
            'stockDisponible'      => $request->stockDisponible,
            'precio'               => $request->precio,
        ]);

        return redirect('/admin/inventario')->with('success', 'Producto agregado con éxito.');
    }

    // Muestra el formulario de edición con los datos actuales
    public function edit($id)
    {
        $producto = DB::table('productos_farma')->where('idProducto', $id)->first();
        return view('admin.inventario_form', compact('producto'));
    }

    // Actualiza el producto en la base de datos
    public function update(Request $request, $id)
    {
        DB::table('productos_farma')->where('idProducto', $id)->update([
            'nombre'               => $request->nombre,
            'concentracionCBD_THC' => $request->concentracionCBD_THC,
            'stockDisponible'      => $request->stockDisponible,
            'precio'               => $request->precio,
        ]);

        return redirect('/admin/inventario')->with('success', 'Producto actualizado con éxito.');
    }

    // Elimina el producto
    public function destroy($id)
    {
        DB::table('productos_farma')->where('idProducto', $id)->delete();
        return redirect('/admin/inventario')->with('success', 'Producto eliminado con éxito.');
    }
}