<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Weedy - Autenticación</title>
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
<body class="bg-gray-50 font-sans min-h-screen flex flex-col justify-between">

    <!-- Navbar Minimalista -->
    <nav class="bg-white border-b border-gray-200 py-4 shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <span class="text-2xl font-black text-weedyRed tracking-tight">Weedy<span class="text-weedyGreen">.</span></span>
        </div>
    </nav>

    <!-- Tarjeta de Acceso -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="bg-white border border-gray-200 rounded-3xl p-8 shadow-sm w-full max-w-md">
            
            <div class="text-center mb-6">
                <h2 id="auth-titulo" class="text-2xl font-black text-weedyDark uppercase tracking-tight">Iniciar Sesión</h2>
                <p id="auth-subtitulo" class="text-gray-400 text-xs mt-1">Ingresa tus credenciales para acceder a la plataforma.</p>
            </div>

            <!-- Alertas -->
            <div id="contenedor-alerta" class="hidden mb-4 p-3.5 rounded-xl text-xs font-bold border"></div>

            <form id="form-auth" class="space-y-4">
                <div id="campo-nombre" class="hidden">
                    <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Nombre Completo</label>
                    <input type="text" name="nombre" placeholder="Ej. José Mora" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                </div>

                <div id="campo-cedula" class="hidden">
                    <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Cédula de Identidad</label>
                    <input type="text" name="cedula" placeholder="Ej. V-22333444" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                </div>

                <div id="campo-telefono" class="hidden">
                    <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Número de Teléfono</label>
                    <input type="tel" name="telefono" placeholder="Ej. 04121234567" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                </div>

                <div>
                    <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Correo Electrónico</label>
                    <input type="email" name="correo" required placeholder="correo@ejemplo.com" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                </div>

                <div>
                    <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                </div>

                <button type="submit" id="btn-submit" class="w-full bg-weedyRed hover:bg-red-800 text-white font-black text-sm uppercase tracking-wider py-3 rounded-xl transition shadow-md mt-2 cursor-pointer">
                    Ingresar
                </button>
            </form>

            <div class="mt-6 border-t border-gray-100 pt-4 text-center text-xs font-medium text-gray-500">
                <span id="texto-cambio">¿No tienes cuenta?</span> 
                <button type="button" id="btn-cambiar-modo" class="text-weedyGreen hover:text-emerald-700 font-bold underline ml-1 focus:outline-none">Regístrate aquí</button>
            </div>
        </div>
    </main>

    <footer class="bg-weedyDark text-gray-500 py-4 text-center text-[11px]">
        <p>© 2026 Weedy. Conexión de Salud Segura.</p>
    </footer>

    <script>
        const form = document.getElementById('form-auth');
        const btnCambiar = document.getElementById('btn-cambiar-modo');
        const textoCambio = document.getElementById('texto-cambio');
        const btnSubmit = document.getElementById('btn-submit');
        const titulo = document.getElementById('auth-titulo');
        const subtitulo = document.getElementById('auth-subtitulo');
        const alerta = document.getElementById('contenedor-alerta');
        
        const campoNombre = document.getElementById('campo-nombre');
        const campoCedula = document.getElementById('campo-cedula');
        const campoTelefono = document.getElementById('campo-telefono');

        let esRegistro = false;

        btnCambiar.addEventListener('click', () => {
            esRegistro = !esRegistro;
            alerta.className = "hidden";
            form.reset();

            if (esRegistro) {
                titulo.textContent = "Crear Cuenta";
                subtitulo.textContent = "Regístrate para programar tus citas y ver el catálogo.";
                btnSubmit.textContent = "Registrarse";
                textoCambio.textContent = "¿Ya tienes una cuenta?";
                btnCambiar.textContent = "Inicia sesión";
                
                campoNombre.classList.remove('hidden');
                campoCedula.classList.remove('hidden');
                campoTelefono.classList.remove('hidden');

                campoNombre.querySelector('input').required = true;
                campoCedula.querySelector('input').required = true;
                campoTelefono.querySelector('input').required = true;
            } else {
                titulo.textContent = "Iniciar Sesión";
                subtitulo.textContent = "Ingresa tus credenciales para acceder a la plataforma.";
                btnSubmit.textContent = "Ingresar";
                textoCambio.textContent = "¿No tienes cuenta?";
                btnCambiar.textContent = "Regístrate aquí";
                
                campoNombre.classList.add('hidden');
                campoCedula.classList.add('hidden');
                campoTelefono.classList.add('hidden');

                campoNombre.querySelector('input').required = false;
                campoCedula.querySelector('input').required = false;
                campoTelefono.querySelector('input').required = false;
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alerta.className = "hidden";

            const urlBackend = esRegistro ? '/registro' : '/login';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(urlBackend, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(async res => {
                // Verificamos si la respuesta no es JSON (ej. error 500 de PHP o página HTML de error)
                const contentType = res.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return res.json();
                } else {
                    const text = await res.text();
                    console.error("Respuesta HTML del servidor (Error PHP):", text);
                    throw new Error("El servidor devolvió un error HTML en lugar de JSON.");
                }
            })
            .then(data => {
                alerta.className = "mb-4 p-3.5 rounded-xl text-xs font-bold border block";
                alerta.textContent = data.message;

                if (data.status === 'success') {
                    alerta.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
                    if (!esRegistro) {
                        setTimeout(() => { window.location.href = data.redirect; }, 1000);
                    } else {
                        form.reset();
                        btnCambiar.click();
                    }
                } else {
                    alerta.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
                }
            })
            .catch(err => {
                console.error("Detalle del error:", err);
                alerta.className = "mb-4 p-3.5 rounded-xl text-xs font-bold border block bg-red-50 text-red-700 border-red-200";
                alerta.textContent = "Error de conexión o error interno en el servidor.";
            });
        });
    </script>
</body>
</html><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>