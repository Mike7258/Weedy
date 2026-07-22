<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Inventario</title>
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
                <a href="{{ url('/admin/inventario') }}" class="flex items-center space-x-3 bg-red-100 text-red-800 px-4 py-2.5 rounded-lg text-sm font-semibold">
                    <i class="fa-solid fa-box w-5"></i> <span>Inventario</span>
                </a>
                <a href="{{ url('/admin/Pedidos') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
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
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Inventario de Productos</h1>
                <a href="{{ url('/admin/inventario/crear') }}" class="bg-weedyGreen text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:opacity-90 transition">
                    <i class="fa-solid fa-plus mr-1"></i> Agregar Producto
                </a>
            </div>
                    <!-- Barra de Búsqueda y Filtros (Inventario) -->
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
                        <form action="{{ url('/admin/inventario') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                            
                            <!-- Input de Búsqueda -->
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                                    </div>
                                    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar producto por nombre o ID..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-weedyGreen focus:border-weedyGreen outline-none text-sm transition">
                                </div>
                            </div>
                            
                            <!-- Filtro por Stock -->
                            <div class="w-full md:w-64">
                                <select name="stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-weedyGreen focus:border-weedyGreen outline-none text-sm text-gray-600 transition">
                                    <option value="">Todo el inventario</option>
                                    <option value="bajo" {{ request('stock') == 'bajo' ? 'selected' : '' }}>Stock bajo (Menos de 20)</option>
                                    <option value="suficiente" {{ request('stock') == 'suficiente' ? 'selected' : '' }}>Stock suficiente (20 o más)</option>
                                </select>
                            </div>
                            
                            <!-- Botones -->
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-red-600 hover:bg-red-600 text-white px-6 py-2 rounded-lg text-sm font-semibold shadow transition">
                                    Buscar
                                </button>
                                @if(request('buscar') || request('stock'))
                                    <a href="{{ url('/admin/inventario') }}" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center" title="Limpiar filtros">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
            <!-- TABLA DE INVENTARIO -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-3">ID</th>
                                <th class="pb-3">Nombre del Producto</th>
                                <th class="pb-3">Stock Disponible</th>
                                <th class="pb-3">Precio</th>
                                <th class="pb-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($productos as $prod)
                                <tr>
                                    <td class="py-3 font-semibold text-gray-600">{{ $prod->id ?? $prod->idProducto ?? 'N/A' }}</td>
                                    <td class="py-3 font-medium text-gray-900">{{ $prod->nombreProducto ?? $prod->nombre ?? 'Sin nombre' }}</td>
                                    <td class="py-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ ($prod->stockDisponible ?? 0) < 20 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-75orka' }}">
                                            {{ $prod->stockDisponible ?? 0 }} unids.
                                        </span>
                                    </td>
                                    <td class="py-3 text-gray-600">${{ number_format($prod->precio ?? 0, 2) }}</td>
                                    <td class="py-3 text-right space-x-2">
                                        <a href="{{ url('/admin/inventario/editar/' . ($prod->id ?? $prod->idProducto)) }}" class="text-blue-600 hover:text-blue-900 font-medium">Editar</a>
                                        <a href="{{ url('/admin/inventario/eliminar/' . ($prod->id ?? $prod->idProducto)) }}" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-400">No hay productos registrados en el inventario.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>