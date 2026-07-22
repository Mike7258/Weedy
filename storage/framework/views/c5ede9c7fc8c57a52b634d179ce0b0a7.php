<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Cannabis Medicinal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        weedyRed: '#A61414',   
                        weedyGreen: '#5D7A3A', 
                        weedyDark: '#1A1A1A',  
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

    <!-- Navbar Weedy Inteligente -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <span class="text-2xl font-black text-weedyRed tracking-tight">Weedy<span class="text-weedyGreen">.</span></span>
                <div class="hidden md:flex space-x-6 text-sm font-bold text-gray-500">
                    <a href="<?php echo e(url('/')); ?>" class="text-weedyRed border-b-2 border-weedyRed pb-5 pt-5">Inicio</a>
                    <a href="<?php echo e(url('/tienda')); ?>" class="hover:text-weedyRed pb-5 pt-5 transition">Tienda</a>
                    <a href="<?php echo e(url('/consultas')); ?>" class="hover:text-weedyRed pb-5 pt-5 transition">Consultas</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-600 hover:text-weedyRed cursor-pointer transition text-xl p-1.5 hover:bg-gray-100 rounded-full">🛒</span>
                
                <!-- CONTROL DE FLUJO DINÁMICO DEL AVATAR -->
                <?php if(session()->has('user_id')): ?>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-weedyGreen text-white flex items-center justify-center font-bold text-sm shadow-inner select-none animate-fade-in" title="<?php echo e($nombreCompleto); ?>">
                            <?php echo e($inicialesUsuario); ?>

                        </div>
                        <a href="<?php echo e(url('/logout')); ?>" class="text-xs font-bold text-gray-400 hover:text-weedyRed transition border-l border-gray-200 pl-3">
                            Cerrar Sesión
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>" class="bg-weedyGreen hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-sm">
                        Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-weedyRed py-24 px-4 border-b-4 border-weedyGreen text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
            <!-- Columna Izquierda -->
            <div class="lg:col-span-7 text-center md:text-left">
                <span class="bg-white/20 text-white text-xs font-black px-3 py-1 rounded-md uppercase tracking-widest border border-white/30">
                    Distribución Médica Certificada
                </span>
                
                <!-- Saludo dinámico si el usuario inició sesión -->
                <h1 class="text-4xl md:text-5xl font-black mt-5 tracking-tight leading-tight uppercase text-white">
                    <?php if(session()->has('user_id')): ?>
                        ¡Hola, <?php echo e($primerNombre); ?>! El equilibrio natural <br class="hidden md:inline">que tu cuerpo necesita.
                    <?php else: ?>
                        El equilibrio que tu cuerpo necesita, <br class="hidden md:inline">de forma natural.
                    <?php endif; ?>
                </h1>
                
                <p class="text-red-100 mt-4 text-lg max-w-xl font-medium">
                    <?php if(session()->has('user_id')): ?>
                        Tu sesión clínica se encuentra iniciada correctamente. Ya tienes acceso sin restricciones a nuestro catálogo terapéutico completo y al gestor dinámico de citas de telemedicina.
                    <?php else: ?>
                        Acceso seguro, legal y simplificado a tratamientos de cannabis medicinal certificados por laboratorios autorizados bajo estricto seguimiento clínico.
                    <?php endif; ?>
                </p>
                
                <div class="mt-8 flex flex-wrap gap-4 justify-center md:justify-start">
                    <a href="<?php echo e(url('/tienda')); ?>" class="bg-gray-900 hover:bg-black text-white font-black px-8 py-3.5 rounded-xl text-sm transition shadow-md hover:shadow-lg flex items-center gap-2 tracking-wide uppercase">
                        Explorar Catálogo <span>→</span>
                    </a>
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="lg:col-span-5 hidden lg:flex justify-center items-center">
                <div class="border-4 border-white/10 rounded-full p-6 bg-white/5 backdrop-blur-sm shadow-2xl transition duration-300 hover:border-white/20">
                    <div class="w-72 h-72 rounded-full border-2 border-dashed border-gray-200 bg-white flex flex-col items-center justify-center text-center p-6 shadow-inner transform hover:scale-105 transition duration-300">
                        <!-- Se asume que el logo.png está en la carpeta public/ -->
                        <img src="<?php echo e(asset('logo.png')); ?>" alt="Weedy Logo" class="w-36 h-36 object-contain select-none">
                        <span class="text-4xl font-serif font-semibold text-gray-950 mt-1 tracking-tight select-none">Weedy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Especialidades -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 flex-grow">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-8 h-1 bg-weedyRed rounded-full"></div>
            <h3 class="text-3xl font-black text-weedyDark tracking-tight uppercase">Nos especializamos en</h3>
        </div>
        <p class="text-gray-500 text-sm mb-12 max-w-2xl font-medium">Suministro confiable, seguro y rápido de productos farmacéuticos y de atención médica directamente a profesionales de la salud y pacientes.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white border-2 border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition flex flex-col items-start text-left border-t-4 border-t-weedyRed">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-weedyRed text-2xl mb-5 shadow-inner">💊</div>
                <h4 class="font-extrabold text-weedyDark text-xl tracking-tight">Vitaminas y Suplementos</h4>
                <p class="text-gray-500 text-sm mt-3 leading-relaxed font-medium">Nutrientes diarios esenciales y soporte inmunológico integral para la estabilidad y balance del organismo.</p>
            </div>
            
            <div class="bg-weedyGreen border border-weedyGreen rounded-2xl p-8 shadow-md hover:shadow-lg transition flex flex-col items-start text-left text-white">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white text-2xl mb-5 shadow-inner">🩹</div>
                <h4 class="font-extrabold text-xl tracking-tight">Alivio del Dolor</h4>
                <p class="text-green-50 text-sm mt-3 leading-relaxed font-medium">Soluciones dirigidas al manejo y control efectivo de dolores crónicos, inflamaciones y afecciones complejas.</p>
            </div>
            
            <div class="bg-amber-50/60 border-2 border-amber-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition flex flex-col items-start text-left">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-amber-600 text-2xl mb-5 shadow-sm border border-amber-100">❤️</div>
                <h4 class="font-extrabold text-weedyDark text-xl tracking-tight">Bienestar Integral</h4>
                <p class="text-gray-600 text-sm mt-3 leading-relaxed font-medium">Soporte diario para el manejo del estrés, conciliación del sueño y equilibrio corporal a través de alternativas botánicas naturales.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-weedyDark text-gray-400 border-t border-gray-800 py-12 text-center text-xs mt-auto">
        <p class="font-black text-white text-xl mb-4 tracking-widest uppercase">Weedy<span class="text-weedyGreen">.</span></p>
        <div class="flex justify-center space-x-6 mb-6 flex-wrap gap-y-2 font-semibold">
            <a href="#" class="hover:text-white transition">Política de Privacidad</a>
            <a href="#" class="hover:text-white transition">Términos del Servicio</a>
            <a href="#" class="hover:text-white transition">Descargo Médico</a>
            <a href="#" class="hover:text-white transition">Soporte Técnico</a>
        </div>
        <p class="text-gray-500">© 2026 Weedy. Distribuidor Autorizado de Cannabis Medicinal.</p>
    </footer>

</body>
</html><?php /**PATH /var/www/html/resources/views/index.blade.php ENDPATH**/ ?>