<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
{
    $query = DB::table('pedidos_envio')
    ->leftJoin('usuarios', 'pedidos_envio.idUsuario', '=', 'usuarios.idUsuario')
    ->select(
        'pedidos_envio.*', 
        'usuarios.nombreCompleto as nombre_usuario', 
        'usuarios.correoElectronico as correo_usuario',
        'usuarios.cedulaIdentidad as cedula_usuario',
        'usuarios.telefono as telefono_usuario'   
    );

    // 2. Filtro de búsqueda (permite buscar por ID, tracking o nombre completo del usuario)
    if ($request->filled('buscar')) {
        $busqueda = $request->buscar;
        $query->where(function($q) use ($busqueda) {
            $q->where('pedidos_envio.idPedido', 'like', '%' . $busqueda . '%')
              ->orWhere('pedidos_envio.trackingNumber', 'like', '%' . $busqueda . '%')
              ->orWhere('usuarios.nombreCompleto', 'like', '%' . $busqueda . '%');
        });
    }

    if ($request->filled('estado')) {
        $query->where('pedidos_envio.estadoEnvio', $request->estado);
    }

    $pedidos = $query->orderByDesc('pedidos_envio.idPedido')->get();
    
    return view('admin.pedidos', compact('pedidos'));
}

    public function detalles($id)
{
    $pedido = DB::table('pedidos_envio')
        ->leftJoin('usuarios', 'pedidos_envio.idUsuario', '=', 'usuarios.idUsuario')
        ->select(
            'pedidos_envio.*', 
            'usuarios.nombreCompleto as nombre_usuario', 
            'usuarios.correoElectronico as correo_usuario',
            'usuarios.cedulaIdentidad as cedula_usuario',
            'usuarios.telefono as telefono_usuario'
        )
        ->where('pedidos_envio.idPedido', $id)
        ->first();

    if (!$pedido) {
        return redirect('/admin/Pedidos')->with('error', 'Pedido no encontrado.');
    }

    return view('admin.ordenes_detalles', compact('pedido'));
}

public function actualizarDetalles(Request $request, $id)
{
    $request->validate([
        'trackingNumber' => 'nullable|string|max:255',
        'estadoEnvio' => 'required|in:Pendiente,Confirmado,Rechazado',
        'direccionEntrega' => 'required|string',
        'notas' => 'nullable|string'
    ]);

    DB::table('pedidos_envio')
        ->where('idPedido', $id)
        ->update([
            'trackingNumber' => $request->trackingNumber,
            'estadoEnvio' => $request->estadoEnvio,
            'direccionEntrega' => $request->direccionEntrega,
            'notas' => $request->notas, // Asegúrate de tener esta columna en tu tabla pedidos_envio o agrégala con SQL
            'updated_at' => now()
        ]);

    return back()->with('success', 'Pedido actualizado correctamente.');
}

}