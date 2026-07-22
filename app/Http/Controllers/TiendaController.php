<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiendaController extends Controller
{
    // Muestra la vista principal de la tienda (Catálogo y Mis Pedidos)
    public function index()
    {
        $inicialesUsuario = "";
        $nombreCompleto = "";
        $pedidos = [];

        if (session()->has('user_id')) {
            $nombreCompleto = session('user_name');
            $palabras = explode(' ', $nombreCompleto);
            $inicialesUsuario = strtoupper(substr($palabras[0] ?? 'U', 0, 1) . substr($palabras[1] ?? '', 0, 1));

            // Consultar los pedidos del usuario logueado usando Query Builder de Laravel
            try {
                $pedidos = DB::table('pedidos_envio as p')
                    ->join('pedido_productos as dp', 'p.idPedido', '=', 'dp.idPedido')
                    ->join('productos_farma as pf', 'dp.idProducto', '=', 'pf.idProducto')
                    ->where('p.idUsuario', session('user_id'))
                    ->select(
                        'p.idPedido', 
                        'p.trackingNumber', 
                        'p.direccionEntrega', 
                        'p.estadoEnvio', 
                        'p.notas', 
                        'p.updated_at',
                        DB::raw("GROUP_CONCAT(CONCAT(pf.nombre, ' (x', dp.cantidad, ') — $', FORMAT(pf.precio * dp.cantidad, 2)) SEPARATOR '<br>') as productos_detalle"),
                        DB::raw("SUM(pf.precio * dp.cantidad) as total_pedido")
                    )
                    ->groupBy('p.idPedido', 'p.trackingNumber', 'p.direccionEntrega', 'p.estadoEnvio', 'p.notas', 'p.updated_at')
                    ->orderBy('p.updated_at', 'DESC')
                    ->get();
            } catch (\Exception $e) {
                $pedidos = [];
            }
        }

        return view('tienda', compact('inicialesUsuario', 'nombreCompleto', 'pedidos'));
    }

    // Filtra los productos de forma dinámica (AJAX)
    public function filtrar(Request $request)
    {
        $busqueda = trim($request->input('busqueda', ''));
        $categorias = $request->input('categorias', []);
        $precioMin = $request->input('precio_min');
        $precioMax = $request->input('precio_max');

        $query = DB::table('productos_farma');

        if (!empty($busqueda)) {
            $query->where('nombre', 'LIKE', "%{$busqueda}%");
        }

        if (!empty($categorias)) {
            $query->whereIn('categoria', $categorias);
        }

        if (is_numeric($precioMin)) {
            $query->where('precio', '>=', $precioMin);
        }

        if (is_numeric($precioMax)) {
            $query->where('precio', '<=', $precioMax);
        }

        $productos = $query->get();

        if ($productos->count() > 0) {
            foreach ($productos as $prod) {
                $stock = $prod->stockDisponible ?? 0;
                $idProd = $prod->idProducto ?? '';
                $nombreProd = $prod->nombre ?? '';
                $precioProd = $prod->precio ?? 0;
                $categoriaProd = $prod->categoria ?? 'General';
                $cbdThc = $prod->concentracionCBD_THC ?? '';
                $descripcion = $prod->descripcion ?? '';
                // Imagen por defecto si está vacía
                $imagen = !empty($prod->imagen) ? asset('storage/' . $prod->imagen) : 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&q=80&w=300';
                
                $stockColor = $stock > 5 ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50';
                
                echo '<div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">';
                echo '<div>';
                // Contenedor de la Imagen del Producto
                echo '<div class="w-full h-40 bg-gray-100 rounded-xl mb-4 overflow-hidden relative flex items-center justify-center">';
                echo '<img src="' . $imagen . '" alt="' . htmlspecialchars($nombreProd) . '" class="w-full h-full object-cover hover:scale-105 transition duration-300">';
                echo '<span class="absolute top-2 left-2 text-[10px] font-black uppercase px-2.5 py-1 rounded-md bg-white/90 text-gray-700 shadow-sm backdrop-blur-sm">' . htmlspecialchars($categoriaProd) . '</span>';
                echo '</div>';

                echo '<div class="flex justify-between items-start mb-2">';
                echo '<h4 class="font-black text-weedyDark text-base tracking-tight mb-1">' . htmlspecialchars($nombreProd) . '</h4>';
                echo '<span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-md ' . $stockColor . ' tracking-wider shrink-0">Stock: ' . $stock . '</span>';
                echo '</div>';

                if (!empty($cbdThc)) {
                    echo '<p class="text-[11px] font-bold text-weedyGreen mb-1">🌿 CBD/THC: ' . htmlspecialchars($cbdThc) . '</p>';
                }
                if (!empty($descripcion)) {
                    echo '<p class="text-gray-500 text-xs line-clamp-2 font-medium mb-4">' . htmlspecialchars($descripcion) . '</p>';
                }
                echo '</div>';

                echo '<div class="border-t border-gray-100 pt-4 flex items-center justify-between mt-auto">';
                echo '<span class="text-xl font-black text-weedyDark">$' . number_format($precioProd, 2) . '</span>';
                echo '<div class="flex items-center gap-2">';
                echo '<input type="number" id="cant-' . $idProd . '" value="1" min="1" max="' . $stock . '" class="w-14 border border-gray-300 rounded-xl px-2 py-1.5 text-xs text-center font-bold bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen">';
                echo '<button onclick="agregarAlCarrito(\'' . $idProd . '\', \'' . addslashes($nombreProd) . '\', ' . $precioProd . ', ' . $stock . ', \'' . $imagen . '\')" class="bg-weedyGreen hover:bg-emerald-800 text-white font-black text-xs px-4 py-2 rounded-xl transition shadow-sm uppercase tracking-wide">Añadir</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="bg-white border border-gray-200 rounded-2xl p-12 text-center text-gray-400 font-medium italic col-span-2">';
            echo '🔍 No se encontraron productos médicos con los filtros seleccionados.';
            echo '</div>';
        }
    }

    // Procesa la pasarela de pago y guarda el pedido
    public function procesarPedido(Request $request)
    {
        if (!session()->has('user_id')) {
            return response()->json(['status' => 'error', 'message' => 'Debes iniciar sesión para realizar un pedido.']);
        }

        $direccion = trim($request->input('direccion', 'Entrega a Domicilio Principal'));
        $numTarjeta = trim($request->input('num_tarjeta', ''));
        $expTarjeta = trim($request->input('exp_tarjeta', ''));
        $cvcTarjeta = trim($request->input('cvc_tarjeta', ''));
        $carritoJson = $request->input('carrito', '[]');
        $carrito = json_decode($carritoJson, true);

        if (empty($carrito) || !is_array($carrito)) {
            return response()->json(['status' => 'error', 'message' => 'El carrito está vacío.']);
        }

        if (empty($direccion)) {
            return response()->json(['status' => 'error', 'message' => 'Por favor, ingresa la dirección de entrega.']);
        }

        // Validar datos básicos de tarjeta Visa/Mastercard
        $tarjetaLimpia = preg_replace('/\s+/', '', $numTarjeta);
        if (empty($tarjetaLimpia) || strlen($tarjetaLimpia) < 15 || empty($expTarjeta) || strlen($cvcTarjeta) < 3) {
            return response()->json(['status' => 'error', 'message' => 'Por favor, ingresa un número de tarjeta, fecha y CVC válidos.']);
        }

        try {
            DB::beginTransaction();

            $userId = session('user_id');

            // 1. Obtener Récipe Digital de prueba si existe
            $idCita = null;
            $cita = DB::table('citas_telemedicina as c')
                ->join('diarios_dosificacion as d', 'c.idCita', '=', 'd.idCita')
                ->where('d.idPaciente', $userId)
                ->select('c.idCita')
                ->first();

            if ($cita) {
                $idCita = $cita->idCita;
            }

            $idRecipe = "REC-" . substr(md5(uniqid(rand(), true)), 0, 8);
            DB::table('recipes_digitales')->insert([
                'idRecipe'         => $idRecipe,
                'codigoQR'         => 'QR-DEFAULT',
                'tokenCifrado'     => 'TOKEN-SECURE-WEEDY',
                'fechaVencimiento' => date('Y-m-d', strtotime('+30 days')),
                'idCita'           => $idCita
            ]);

            // 2. Crear Pedido de Envío
            $idPedido = "PED-" . substr(md5(uniqid(rand(), true)), 0, 10);
            $tracking = "TRK-WD-" . rand(100000, 999999);
            $notasPago = "Pago Procesado con Tarjeta de Crédito (**** **** **** " . substr($tarjetaLimpia, -4) . ")";

            DB::table('pedidos_envio')->insert([
                'idPedido'         => $idPedido,
                'idUsuario'        => $userId,
                'trackingNumber'   => $tracking,
                'direccionEntrega' => $direccion,
                'estadoEnvio'      => 'En Procesamiento',
                'notas'            => $notasPago,
                'idRecipe'         => $idRecipe,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // 3. Registrar detalles del pedido y restar Stock (`stockDisponible`)
            foreach ($carrito as $item) {
                DB::table('pedido_productos')->insert([
                    'idPedido'   => $idPedido,
                    'idProducto' => $item['id'],
                    'cantidad'   => $item['cantidad']
                ]);

                DB::table('productos_farma')
                    ->where('idProductore', $item['id']) // o idProducto según tu esquema
                    ->where('idProducto', $item['id'])
                    ->decrement('stockDisponible', $item['cantidad']);
            }

            DB::commit();

            return response()->json([
                'status'   => 'success',
                'message'  => '¡Pago aprobado con éxito!',
                'tracking' => $tracking
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Error al procesar el pago: ' . $e->getMessage()]);
        }
    }
}