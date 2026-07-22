<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Gestor de Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] } } } }
    </script>
    <style>body { background-color: #F4F7F6; }</style>
</head>
<body class="text-gray-800 font-sans h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm w-full max-w-lg">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            <?php echo e(isset($producto) ? 'Editar Producto' : 'Nuevo Producto'); ?>

        </h1>

        <form action="<?php echo e(isset($producto) ? url('/admin/inventario/actualizar/' . $producto->idProducto) : url('/admin/inventario/guardar')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto</label>
                <input type="text" name="nombre" value="<?php echo e($producto->nombre ?? $producto->nombre ?? $producto->descripcion ?? ''); ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock Disponible</label>
                <input type="number" name="stockDisponible" value="<?php echo e($producto->stockDisponible ?? ''); ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio ($)</label>
                <input type="number" step="0.01" name="precio" value="<?php echo e($producto->precio ?? ''); ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div class="mb-6">
                <label for="concentracionCBD_THC" class="block text-sm font-medium text-gray-700 mb-1">Concentración CBD/THC</label>
                <input type="text" name="concentracionCBD_THC" id="concentracionCBD_THC" value="<?php echo e($producto->concentracionCBD_THC ?? ''); ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="<?php echo e(url('/admin/inventario')); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                    <?php echo e(isset($producto) ? 'Actualizar' : 'Guardar'); ?>

                </button>
            </div>
        </form>
    </div>

</body>
</html><?php /**PATH /var/www/html/resources/views/admin/inventario_form.blade.php ENDPATH**/ ?>