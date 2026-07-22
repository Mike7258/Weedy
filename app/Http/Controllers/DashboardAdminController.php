<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    
    public function index()
{
    $data = [
        'totalProductos'      => \DB::table('productos_farma')->count(),
        'totalPacientes'      => \DB::table('pacientes')->count(),
        'pedidosActivos'      => \DB::table('pedidos_envio')->where('estadoEnvio', '!=', 'Entregado')->count(), // <--- NUEVO
        'productosBajoStock'  => \DB::table('productos_farma')->where('stockDisponible', '<', 20)->get(),
        'ordenesRecientes'    => \DB::table('pedidos_envio')->orderBy('idPedido', 'desc')->limit(5)->get()
    ];

    return view('admin.DashboardAdmin', $data);
}

    public function showDetalles($id)
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
        'estadoEnvio' => 'required|in:Pendiente,Confirmado,Rechazado',
        'direccionEntrega' => 'required|string',
    ]);

    DB::table('pedidos_envio')
        ->where('idPedido', $id)
        ->update([
            'trackingNumber' => $request->trackingNumber,
            'estadoEnvio' => $request->estadoEnvio,
            'direccionEntrega' => $request->direccionEntrega,
            'notas' => $request->notas,
            'updated_at' => now()
        ]);

    // Debe redirigir hacia atrás, nunca cargar una vista directamente aquí
    return redirect('/admin/ordenes/detalles/' . $id)->with('success', 'Pedido actualizado correctamente.');
}

public function indexPacientes()
{
    $pacientes = DB::table('pacientes')
        ->join('usuarios', 'pacientes.idUsuario', '=', 'usuarios.idUsuario')
        ->select(
            'pacientes.*',
            'usuarios.nombreCompleto',
            'usuarios.cedulaIdentidad',
            'usuarios.correoElectronico',
            'usuarios.telefono'
        )
        ->get();

    return view('admin.pacientes', compact('pacientes'));
}

public function editarPaciente($id)
    {
        // Buscamos los datos unificados del paciente y su información de usuario
        $paciente = DB::table('pacientes')
            ->join('usuarios', 'pacientes.idUsuario', '=', 'usuarios.idUsuario')
            ->where('pacientes.idUsuario', $id)
            ->select('pacientes.*', 'usuarios.nombreCompleto', 'usuarios.cedulaIdentidad', 'usuarios.correoElectronico', 'usuarios.telefono')
            ->first();

        if (!$paciente) {
            return redirect('/admin/pacientes')->with('error', 'Paciente no encontrado.');
        }

        return view('admin.pacientes_editar', compact('paciente'));
    }

    public function actualizarPaciente(Request $request, $id)
    {
        // Actualizamos los datos generales en la tabla 'usuarios'
        DB::table('usuarios')
            ->where('idUsuario', $id)
            ->update([
                'nombreCompleto' => $request->nombreCompleto,
                'cedulaIdentidad' => $request->cedulaIdentidad,
                'correoElectronico' => $request->correoElectronico,
                'telefono' => $request->telefono,
            ]);

        // Actualizamos los datos médicos en la tabla 'pacientes'
        DB::table('pacientes')
            ->where('idUsuario', $id)
            ->update([
                'documentosValidacion' => $request->documentosValidacion,
                'historialClinico' => $request->historialClinico,
            ]);

        return redirect('/admin/pacientes')->with('success', 'Paciente actualizado correctamente.');
    }

    public function indexEmpleados(Request $request)
{
    // Iniciamos la consulta (asumiendo que los empleados están vinculados a la tabla usuarios)
    $query = DB::table('empleados')
        ->join('usuarios', 'empleados.idUsuario', '=', 'usuarios.idUsuario')
        ->select('empleados.*', 'usuarios.nombreCompleto', 'usuarios.cedulaIdentidad', 'usuarios.correoElectronico', 'usuarios.telefono');

    // Filtro por Búsqueda de texto (Nombre, Cédula o Correo)
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('usuarios.nombreCompleto', 'LIKE', "%{$search}%")
              ->orWhere('usuarios.cedulaIdentidad', 'LIKE', "%{$search}%")
              ->orWhere('usuarios.correoElectronico', 'LIKE', "%{$search}%");
        });
    }

    // Filtro por Rol Exacto (Administrador, Gestor, Doctor)
    if ($request->filled('rol')) {
        $query->where('empleados.rol', $request->input('rol'));
    }

    $empleados = $query->get();

    return view('admin.empleados', compact('empleados'));
}

public function crearEmpleado()
    {
        return view('admin.empleados_crear');
    }

    public function guardarEmpleado(Request $request)
    {
        // Validación de datos
        $request->validate([
            'idUsuario' => 'required|string|max:50|unique:usuarios,idUsuario', // Evita IDs duplicados
            'nombreCompleto' => 'required|string|max:255',
            'cedulaIdentidad' => 'required|string|max:50',
            'correoElectronico' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'rol' => 'required|string|in:Administrador,Gestor,Doctor',
        ]);

        // 1. Guardar los datos base en la tabla 'usuarios'
        DB::table('usuarios')->insert([
            'idUsuario' => $request->idUsuario,
            'nombreCompleto' => $request->nombreCompleto,
            'cedulaIdentidad' => $request->cedulaIdentidad,
            'correoElectronico' => $request->correoElectronico,
            'telefono' => $request->telefono,
        ]);

        // 2. Asignar el rol en la tabla 'empleados'
        DB::table('empleados')->insert([
            'idUsuario' => $request->idUsuario,
            'rol' => $request->rol,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/empleados')->with('success', 'Empleado registrado correctamente.');
    }

    public function editarEmpleado($idUsuario)
    {
        // Buscar al empleado uniendo la tabla usuarios y empleados
        $empleado = DB::table('usuarios')
            ->join('empleados', 'usuarios.idUsuario', '=', 'empleados.idUsuario')
            ->where('usuarios.idUsuario', $idUsuario)
            ->first();

        // Si alguien ingresa un ID que no existe en la URL, lo devolvemos
        if (!$empleado) {
            return redirect('/admin/empleados')->with('error', 'Empleado no encontrado.');
        }

        return view('admin.empleados_editar', compact('empleado'));
    }

    public function actualizarEmpleado(Request $request, $idUsuario)
    {
        // Validación de datos (no validamos idUsuario porque no permitiremos cambiarlo)
        $request->validate([
            'nombreCompleto' => 'required|string|max:255',
            'cedulaIdentidad' => 'required|string|max:50',
            'correoElectronico' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'rol' => 'required|string|in:Administrador,Gestor,Doctor',
        ]);

        // 1. Actualizar los datos base en la tabla 'usuarios'
        DB::table('usuarios')
            ->where('idUsuario', $idUsuario)
            ->update([
                'nombreCompleto' => $request->nombreCompleto,
                'cedulaIdentidad' => $request->cedulaIdentidad,
                'correoElectronico' => $request->correoElectronico,
                'telefono' => $request->telefono,
            ]);

        // 2. Actualizar el rol en la tabla 'empleados'
        DB::table('empleados')
            ->where('idUsuario', $idUsuario)
            ->update([
                'rol' => $request->rol,
                'updated_at' => now(),
            ]);

        return redirect('/admin/empleados')->with('success', 'Empleado actualizado correctamente.');
    }

}