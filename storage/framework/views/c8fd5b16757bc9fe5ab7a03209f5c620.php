<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Editar Paciente</title>
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
        <a href="<?php echo e(url('/admin')); ?>" class="text-2xl font-extrabold text-weedyRed tracking-tight">Weedy<span class="text-gray-800">.</span></a>
        <div class="flex items-center space-x-6">
            <div class="bg-weedyGreen text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs">A</div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shrink-0">
            <nav class="p-4 space-y-1">
                <a href="<?php echo e(url('/admin')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-border-all w-5"></i> <span>Dashboard</span>
                </a>
                
                <a href="<?php echo e(url('/admin/inventario')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-box w-5"></i> <span>Inventario</span>
                </a>
                
                <a href="<?php echo e(url('/admin/Pedidos')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-clipboard-list w-5"></i> <span>Pedidos</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="<?php echo e(url('/admin/pacientes')); ?>" class="flex items-center space-x-3 bg-red-100 text-red-800 px-4 py-2.5 rounded-lg text-sm font-semibold">
                        <i class="fa-solid fa-user-injured w-5"></i> <span>Pacientes</span>
                    </a>
                    <a href="<?php echo e(url('/admin/empleados')); ?>" class="flex items-center space-x-3 text-gray-500 hover:bg-red-50 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-user-tie w-5"></i> <span>Empleados</span>
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-200">
                <a href="<?php echo e(url('/logout')); ?>" class="flex items-center space-x-3 text-gray-500 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-right-from-bracket w-5"></i> <span>Cerrar Sesión</span>
                </a>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="flex items-center space-x-4 mb-6">
                <a href="<?php echo e(url('/admin/pacientes')); ?>" class="text-gray-400 hover:text-weedyRed transition">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Editar Paciente: <span class="text-gray-500 font-medium"><?php echo e($paciente->idUsuario); ?></span></h1>
            </div>

            <!-- FORMULARIO DE EDICIÓN -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 max-w-4xl">
                <form action="<?php echo e(url('/admin/pacientes/actualizar/' . $paciente->idUsuario)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Sección Datos del Usuario -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Información Personal</h2>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                                <input type="text" name="nombreCompleto" value="<?php echo e($paciente->nombreCompleto); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-weedyRed focus:border-weedyRed focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cédula de Identidad</label>
                                <input type="text" name="cedulaIdentidad" value="<?php echo e($paciente->cedulaIdentidad); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-weedyRed focus:border-weedyRed focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                                <input type="email" name="correoElectronico" value="<?php echo e($paciente->correoElectronico); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-weedyRed focus:border-weedyRed focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input type="text" name="telefono" value="<?php echo e($paciente->telefono); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-weedyRed focus:border-weedyRed focus:outline-none transition">
                            </div>
                        </div>

                        <!-- Sección Datos del Paciente -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Información Médica</h2>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Documentos de Validación</label>
                                <textarea name="documentosValidacion" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-weedyRed focus:border-weedyRed focus:outline-none transition"><?php echo e($paciente->documentosValidacion); ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Historial Clínico</label>
                                <textarea name="historialClinico" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-weedyRed focus:border-weedyRed focus:outline-none transition"><?php echo e($paciente->historialClinico); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                        <a href="<?php echo e(url('/admin/pacientes')); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium transition">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-weedyGreen hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center space-x-2">
                            <i class="fa-solid fa-save"></i>
                            <span>Guardar Cambios</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html><?php /**PATH /var/www/html/resources/views/admin/pacientes_editar.blade.php ENDPATH**/ ?>