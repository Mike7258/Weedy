<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Detalles del Pedido</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: { weedyRed: '#A6192E', weedyGreen: '#5A814B', weedyLight: '#F8F9FA' }
                }
            }
        }
    </script>
    <style>body { background-color: #F4F7F6; }</style>
</head>
<body class="text-gray-800 font-sans h-screen flex flex-col overflow-hidden">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 px-8 py-3 flex justify-between items-center z-10 shrink-0">
        <a href="{{ url('/admin') }}" class="text-2xl font-extrabold text-weedyRed tracking-tight">Weedy<span class="text-gray-800">.</span></a>
        <div class="flex items-center space-x-6">
            <div class="bg-weedyGreen text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs">A</div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shrink-0">
            <nav class="p-4 space-y-1">
                <a href="{{ url('/admin') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-border-all w-5"></i> <span>Dashboard</span>
                </a>
                <a href="{{ url('/admin/inventario') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-box w-5"></i> <span>Inventario</span>
                </a>
                <a href="{{ url('/admin/Pedidos') }}" class="flex items-center space-x-3 bg-red-100 text-red-800 px-4 py-2.5 rounded-lg text-sm font-semibold">
                    <i class="fa-solid fa-clipboard-list w-5"></i> <span>Pedidos</span>
                </a>
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ url('/admin/pacientes') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-user-injured w-5"></i> <span>Pacientes</span>
                    </a>
                    <a href="{{ url('/admin/empleados') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-user-tie w-5"></i> <span>Empleados</span>
                    </a>
                </div>
            </nav>
            <div class="p-4 border-t border-gray-200">
                <a href="{{ url('/logout') }}" class="flex items-center space-x-3 text-gray-500 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-right-from-bracket w-5"></i> <span>Cerrar Sesión</span>
                </a>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 p-8 overflow-y-auto">
            <!-- Encabezado con Botón de Regresar -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detalles del pedido {{ $pedido->idPedido }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Modifica la información del envío o añade notas de seguimiento.</p>
                </div>
                <a href="{{ url('/admin/Pedidos') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center space-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Volver a Pedidos</span>
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- FORMULARIO DE EDICIÓN Y DETALLES -->
            <form action="{{ url('/admin/pedidos/actualizar/' . $pedido->idPedido) }}" method="POST" class="bg-white rounded-xl border border-gray-200 shadow-sm max-w-4xl overflow-hidden">
                @csrf
                @method('PUT') <!-- O POST según definas en tu ruta -->

                <!-- Barra superior con ID y Estado Editable -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <span class="font-bold text-gray-700 text-base">ID de Pedido: {{ $pedido->idPedido }}</span>
                    <div class="flex items-center space-x-2">
                        <label class="text-xs font-semibold text-gray-500">Estado:</label>
                        <select name="estadoEnvio" class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 focus:ring-weedyGreen focus:border-weedyGreen outline-none">
                            <option value="Pendiente" {{ ($pedido->estadoEnvio ?? '') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Confirmado" {{ ($pedido->estadoEnvio ?? '') == 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                            <option value="Rechazado" {{ ($pedido->estadoEnvio ?? '') == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- INFORMACIÓN DEL CLIENTE (Solo lectura informativa) -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Información del Cliente</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <span class="text-xs text-gray-400 block">Cliente</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $pedido->nombre_usuario ?? 'No registrado' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <span class="text-xs text-gray-400 block">Cédula</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $pedido->cedula_usuario ?? 'N/A' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <span class="text-xs text-gray-400 block">Teléfono</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $pedido->telefono_usuario ?? 'No registrado' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <span class="text-xs text-gray-400 block">Fecha del Pedido</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $pedido->created_at ?? 'No registrada' }}</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- CAMPOS EDITABLES DEL ENVÍO -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tracking Number -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Número de Tracking</label>
                            <input type="text" name="trackingNumber" value="{{ $pedido->trackingNumber }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-weedyGreen focus:border-weedyGreen outline-none text-sm transition">
                        </div>

                        <!-- ID de Receta Asociada -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Receta Médica Asociada</label>
                            <input type="text" value="{{ $pedido->idRecipe ?? 'N/A' }}" disabled class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm text-gray-500 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Dirección de Entrega -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Dirección de Entrega</label>
                        <textarea name="direccionEntrega" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-weedyGreen focus:border-weedyGreen outline-none text-sm transition">{{ $pedido->direccionEntrega }}</textarea>
                    </div>

                    <!-- Notas del Pedido -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Notas u Observaciones del Pedido</label>
                        <textarea name="notas" rows="3" placeholder="Añadir notas internas o instrucciones especiales para este envío..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-weedyGreen focus:border-weedyGreen outline-none text-sm transition">{{ $pedido->notas ?? '' }}</textarea>
                    </div>

                    <!-- Botón de Guardar -->
                    <div class="pt-4 border-t border-gray-100 flex justify-end space-x-3">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow transition">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>
</html>