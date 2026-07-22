<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        weedyRed: '#A6192E',
                        weedyGreen: '#5A814B',
                        weedyLight: '#F8F9FA'
                    }
                }
            }
        }
    </script>
    <style>body { background-color: #F4F7F6; }</style>
</head>
<body class="text-gray-800 font-sans h-screen flex flex-col overflow-hidden">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 px-8 py-3 flex justify-between items-center z-10 shrink-0">
        <a href="#" class="text-2xl font-extrabold text-weedyRed tracking-tight">Weedy<span class="text-gray-800">.</span></a>
        <div class="flex items-center space-x-6">
            <div class="bg-weedyGreen text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs">A</div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">
        <!-- SIDEBAR -->
<aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shrink-0">
    <nav class="p-4 space-y-1">

        <a href="<?php echo e(url('/admin')); ?>" class="flex items-center space-x-3 bg-red-100 text-red-800 px-4 py-2.5 rounded-lg text-sm font-semibold">
            <i class="fa-solid fa-border-all w-5"></i> <span>Dashboard</span>
        </a>
        <a href="<?php echo e(url('/admin/inventario')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fa-solid fa-box w-5"></i> <span>Inventario</span>
        </a>
        <a href="<?php echo e(url('/admin/Pedidos')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fa-solid fa-clipboard-list w-5"></i> <span>Pedidos</span>
        </a>
        
        <!-- NUEVOS BOTONES -->
        <div class="pt-4 mt-4 border-t border-gray-100">
            <a href="<?php echo e(url('/admin/pacientes')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-user-injured w-5"></i> <span>Pacientes</span>
            </a>
            <a href="<?php echo e(url('/admin/empleados')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-user-tie w-5"></i> <span>Empleados</span>
            </a>
        </div>
    </nav>

    <!-- CERRAR SESIÓN -->
    <div class="p-4 border-t border-gray-200">
        <a href="<?php echo e(url('/logout')); ?>" class="flex items-center space-x-3 text-gray-500 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fa-solid fa-right-from-bracket w-5"></i> <span>Cerrar Sesión</span>
        </a>
    </div>
</aside>

        <!-- CONTENIDO -->
        <main class="flex-1 p-8 overflow-y-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- 1. Productos -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Productos</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($totalProductos ?? 0); ?></p>
                </div>
                
                <!-- 2. Pacientes -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Pacientes Activos</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($totalPacientes ?? 0); ?></p>
                </div>
                
                <!-- 3. Pedidos Activos -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
                    <h3 class="text-blue-500 text-xs uppercase tracking-wider font-semibold">Pedidos Activos</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-2"><?php echo e($pedidosActivos ?? 0); ?></p>
                </div>
                
                <!-- 4. Alerta de Stock -->
                <div class="bg-white p-5 rounded-xl border border-red-200 shadow-sm flex flex-col justify-between">
                    <h3 class="text-red-500 text-xs uppercase tracking-wider font-semibold">Alerta de Stock</h3>
                    <p class="text-2xl font-bold text-red-600 mt-2"><?php echo e(count($productosBajoStock ?? [])); ?></p>
                </div>
            </div>

            <!-- TABLA Y LISTA -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h2 class="text-lg font-bold mb-4">Órdenes Recientes</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-500 border-b">
                                <tr>
                                    <th class="pb-3">ID Pedido</th>
                                    <th class="pb-3">Usuario</th>
                                    <th class="pb-3">Estado</th>
                                    <th class="pb-3 text-right">Acciones</th> 
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php $__empty_1 = true; $__currentLoopData = $ordenesRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="py-3"><?php echo e($orden->idPedido); ?></td>
                                        <td class="py-3 font-semibold text-gray-900"><?php echo e($orden->nombre_usuario ?? 'No registrado'); ?></td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 bg-gray-100 rounded-full text-xs font-semibold">
                                                <?php echo e($orden->estadoEnvio ?? 'Pendiente'); ?>

                                            </span>
                                        </td>
                                        <td class="py-3 text-right">
                                            <!-- Botón de detalles -->
                                            <a href="<?php echo e(url('/admin/ordenes/detalles/' . $orden->idPedido)); ?>" 
                                            class="text-blue-600 hover:text-blue-900 font-medium text-sm">
                                                Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="py-4 text-center">No hay órdenes recientes.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h2 class="text-lg font-bold mb-4">Stock Crítico</h2>
                    <?php $__empty_1 = true; $__currentLoopData = $productosBajoStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex justify-between items-center border-b py-2 text-sm">
                            <span><?php echo e($prod->nombre); ?></span>
                            <span class="text-red-600 font-bold"><?php echo e($prod->stockDisponible); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-400">Todo el stock está normal.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html><?php /**PATH /var/www/html/resources/views/admin/DashboardAdmin.blade.php ENDPATH**/ ?>