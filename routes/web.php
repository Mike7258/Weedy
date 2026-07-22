<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidoController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// ==========================================
// RUTA PRINCIPAL DEL PANEL DE ADMINISTRACIÓN
// ==========================================
Route::get('/admin', [DashboardAdminController::class, 'index'])->name('admin');

// Resto de rutas de administración...
Route::get('/admin/ordenes/detalles/{id}', [DashboardAdminController::class, 'showDetalles']);
Route::put('/admin/pedidos/actualizar/{id}', [DashboardAdminController::class, 'actualizarDetalles']);
Route::get('/admin/pacientes', [DashboardAdminController::class, 'indexPacientes']);
Route::get('/admin/pacientes/editar/{id}', [DashboardAdminController::class, 'editarPaciente']);
Route::put('/admin/pacientes/actualizar/{id}', [DashboardAdminController::class, 'actualizarPaciente']);
Route::get('/admin/empleados', [DashboardAdminController::class, 'indexEmpleados']);
Route::get('/admin/empleados/nuevo', [DashboardAdminController::class, 'crearEmpleado']);
Route::post('/admin/empleados/guardar', [DashboardAdminController::class, 'guardarEmpleado']);
Route::get('/admin/empleados/editar/{idUsuario}', [DashboardAdminController::class, 'editarEmpleado']);
Route::post('/admin/empleados/actualizar/{idUsuario}', [DashboardAdminController::class, 'actualizarEmpleado']);

// Inventario
Route::get('/admin/inventario', [InventarioController::class, 'index']);
Route::get('/admin/inventario/crear', [InventarioController::class, 'create']);
Route::post('/admin/inventario/guardar', [InventarioController::class, 'store']);
Route::get('/admin/inventario/editar/{id}', [InventarioController::class, 'edit']);
Route::post('/admin/inventario/actualizar/{id}', [InventarioController::class, 'update']);
Route::get('/admin/inventario/eliminar/{id}', [InventarioController::class, 'destroy']);

// Pedidos
Route::get('/admin/Pedidos', [PedidoController::class, 'index']);
Route::get('/admin/Pedidos/detalles/{id}', [PedidoController::class, 'detalles']);

// Auth y Sesión
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/registro', [AuthController::class, 'registro']);

Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});

// Tienda
Route::get('/tienda', [TiendaController::class, 'index']);
Route::post('/filtrar-productos', [TiendaController::class, 'filtrar']);
Route::post('/procesar-pedido', [TiendaController::class, 'procesarPedido']);

// Consultas / Telemedicina
Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas');
Route::get('/obtener-disponibilidad', [ConsultaController::class, 'obtenerDisponibilidad']);
Route::post('/guardar-cita', [ConsultaController::class, 'guardarCita']);