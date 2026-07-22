<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Empleados</title>
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
                
                <a href="{{ url('/admin/Pedidos') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-clipboard-list w-5"></i> <span>Pedidos</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ url('/admin/pacientes') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-user-injured w-5"></i> <span>Pacientes</span>
                    </a>
                    <!-- Enlace Activo: Empleados -->
                    <a href="{{ url('/admin/empleados') }}" class="flex items-center space-x-3 bg-red-100 text-red-800 px-4 py-2.5 rounded-lg text-sm font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Empleados</h1>
                <a href="{{ url('/admin/empleados/nuevo') }}" class="bg-weedyRed hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition flex items-center space-x-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Nuevo Empleado</span>
                </a>
            </div>

            <!-- BARRA DE BÚSQUEDA Y FILTROS -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
                <form action="{{ url('/admin/empleados') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    
                    <!-- Input de búsqueda -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, cédula o correo..." 
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-weedyRed focus:border-weedyRed">
                    </div>

                    <!-- Select de filtro por rol -->
                    <div class="w-full md:w-64">
                        <select name="rol" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-weedyRed focus:border-weedyRed text-gray-700 bg-white">
                            <option value="">Todos los roles</option>
                            <option value="Administrador" {{ request('rol') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="Gestor" {{ request('rol') == 'Gestor' ? 'selected' : '' }}>Gestor</option>
                            <option value="Doctor" {{ request('rol') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-red-600 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            Buscar
                        </button>
                        @if(request()->has('search') || request()->has('rol'))
                            <a href="{{ url('/admin/empleados') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TABLA DE EMPLEADOS -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-3">ID Usuario</th>
                                <th class="pb-3">Nombre Completo</th>
                                <th class="pb-3">Rol</th>
                                <th class="pb-3">Correo Electrónico</th>
                                <th class="pb-3">Teléfono</th>
                                <th class="pb-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($empleados as $empleado)
                                <tr>
                                    <td class="py-4 font-medium">{{ $empleado->idUsuario }}</td>
                                    <td class="py-4 font-semibold text-gray-900">{{ $empleado->nombreCompleto ?? 'N/A' }}</td>
                                    <td class="py-4">
                                        <!-- Badges de colores según el rol -->
                                        @if($empleado->rol == 'Administrador')
                                            <span class="bg-purple-100 text-purple-800 px-2.5 py-1 rounded-md text-xs font-semibold">Administrador</span>
                                        @elseif($empleado->rol == 'Doctor')
                                            <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-md text-xs font-semibold">Doctor</span>
                                        @elseif($empleado->rol == 'Gestor')
                                            <span class="bg-orange-100 text-orange-800 px-2.5 py-1 rounded-md text-xs font-semibold">Gestor</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded-md text-xs font-semibold">{{ $empleado->rol ?? 'Sin rol' }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-gray-600">{{ $empleado->correoElectronico ?? 'N/A' }}</td>
                                    <td class="py-4 text-gray-600">{{ $empleado->telefono ?? 'No registrado' }}</td>
                                    <td class="py-4 text-right flex justify-end space-x-2">
                                        
                                        <!-- Botón Editar -->
                                        <a href="{{ url('/admin/empleados/editar/' . $empleado->idUsuario) }}" class="text-blue-600 hover:text-weedyGreen transition p-1">
                                            <i class="fa-solid fa-pen"></i>
                                            <span>Editar</span>
                                        </a>

                                        <!-- Botón Borrar -->
                                        <form action="{{ url('/admin/empleados/eliminar/' . $empleado->idUsuario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este empleado?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1.5 rounded-lg font-medium text-xs transition inline-flex items-center space-x-1">
                                                <i class="fa-solid fa-trash"></i>
                                                <span>Borrar</span>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300"></i>
                                            <p>No se encontraron empleados con los filtros aplicados.</p>
                                        </div>
                                    </td>
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