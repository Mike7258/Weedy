<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Catálogo de Productos</title>
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

    <!-- Notificación Toast Flotante -->
    <div id="toast-notif" class="fixed bottom-5 right-5 bg-weedyDark text-white px-5 py-3 rounded-2xl shadow-2xl flex items-center gap-3 z-50 transform translate-y-20 opacity-0 transition-all duration-300">
        <span class="text-xl">🛒</span>
        <span id="toast-mensaje" class="text-xs font-bold">Producto añadido al carrito.</span>
    </div>

    <!-- Navbar Weedy Dinámico -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <span class="text-2xl font-black text-weedyRed tracking-tight">Weedy<span class="text-weedyGreen">.</span></span>
                <div class="hidden md:flex space-x-6 text-sm font-bold text-gray-500">
                    <a href="{{ url('/') }}" class="hover:text-weedyRed pb-5 pt-5 transition">Inicio</a>
                    <a href="{{ url('/tienda') }}" class="text-weedyRed border-b-2 border-weedyRed pb-5 pt-5">Tienda</a>
                    <a href="{{ url('/consultas') }}" class="hover:text-weedyRed pb-5 pt-5 transition">Consultas</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" id="input-busqueda" placeholder="Buscar productos..." class="border border-gray-300 rounded-full px-4 py-1.5 text-sm bg-gray-50 w-64 focus:outline-none focus:ring-2 focus:ring-weedyGreen">
                </div>
                
                <!-- Botón Carrito con Contador -->
                <button onclick="toggleModalCarrito()" class="relative text-gray-600 hover:text-weedyRed cursor-pointer transition text-xl p-1.5 hover:bg-gray-100 rounded-full">
                    🛒
                    <span id="badge-carrito" class="absolute -top-1 -right-1 bg-weedyRed text-white font-black text-[10px] w-5 h-5 rounded-full flex items-center justify-center hidden">0</span>
                </button>

                <!-- Avatar Dinámico del Usuario Logueado -->
                @if (session()->has('user_id'))
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-weedyGreen text-white flex items-center justify-center font-bold text-sm shadow-inner select-none" title="{{ $nombreCompleto }}">
                            {{ $inicialesUsuario }}
                        </div>
                        <a href="{{ url('/logout') }}" class="text-xs font-bold text-gray-400 hover:text-weedyRed transition border-l border-gray-200 pl-3">
                            Cerrar Sesión
                        </a>
                    </div>
                @else
                    <a href="{{ url('/login') }}" class="bg-weedyGreen hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-sm">
                        Iniciar Sesión
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">
        
        <!-- PESTAÑAS DENTRO DE LA TIENDA -->
        <div class="flex border-b border-gray-200 mb-8 text-sm font-bold">
            <button id="tab-catalogo" class="border-b-2 border-weedyGreen text-weedyGreen px-6 py-2.5 transition flex items-center gap-2">
                <span>🛍️</span> Catálogo de Productos
            </button>
            <button id="tab-pedidos" class="border-b-2 border-transparent text-gray-400 hover:text-gray-600 px-6 py-2.5 transition flex items-center gap-2">
                <span>📦</span> Mis Pedidos Realizados
            </button>
        </div>

        <!-- SECCIÓN 1: CATÁLOGO Y FILTROS -->
        <div id="panel-catalogo" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Panel de Filtros Adhesivo -->
            <aside class="lg:col-span-3 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm h-fit sticky top-24 z-10">
                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                    <h3 class="text-lg font-black text-weedyDark uppercase tracking-wide">Filtros</h3>
                    <button type="button" onclick="document.getElementById('form-filtros').reset(); document.getElementById('input-busqueda').value=''; actualizarCatalogo();" class="text-[11px] font-bold text-weedyGreen hover:underline uppercase tracking-wide">
                        Limpiar
                    </button>
                </div>
                
                <form id="form-filtros">
                    <div class="mb-6">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Categoría</span>
                        <div class="space-y-2 text-xs font-medium text-gray-700">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="categorias[]" value="Aceites y Extractos" class="rounded text-weedyGreen focus:ring-weedyGreen w-4 h-4"> Aceites y Extractos
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="categorias[]" value="Suplementos y Cápsulas" class="rounded text-weedyGreen focus:ring-weedyGreen w-4 h-4"> Suplementos y Cápsulas
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="categorias[]" value="Cremas y Tópicos" class="rounded text-weedyGreen focus:ring-weedyGreen w-4 h-4"> Cremas y Tópicos
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="categorias[]" value="Gomitas y Comestibles" class="rounded text-weedyGreen focus:ring-weedyGreen w-4 h-4"> Gomitas y Comestibles
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="categorias[]" value="Vaporizadores e Inhaladores" class="rounded text-weedyGreen focus:ring-weedyGreen w-4 h-4"> Vaporizadores e Inhaladores
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="categorias[]" value="Infusiones y Tés" class="rounded text-weedyGreen focus:ring-weedyGreen w-4 h-4"> Infusiones y Tés
                            </label>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3">Rango de Precio ($)</span>
                        <div class="flex items-end gap-2">
                            <div class="w-full">
                                <label for="precio-min" class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Mínimo</label>
                                <input type="number" name="precio_min" id="precio-min" placeholder="0" min="0" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                            </div>
                            <span class="text-gray-300 font-bold mb-2.5">—</span>
                            <div class="w-full">
                                <label for="precio-max" class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Máximo</label>
                                <input type="number" name="precio_max" id="precio-max" placeholder="Max" min="0" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                            </div>
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Catálogo de Productos -->
            <section class="lg:col-span-9">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4 mb-6 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-1 bg-weedyRed rounded-full"></div>
                        <h2 class="text-3xl font-black text-weedyDark uppercase tracking-tight">Productos Médicos</h2>
                    </div>
                </div>

                <div id="contenedor-productos" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6"></div>
            </section>
        </div>

        <!-- SECCIÓN 2: MIS PEDIDOS -->
        <div id="panel-pedidos" class="space-y-6 hidden">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-6 h-1 bg-weedyRed rounded-full"></div>
                <h2 class="text-3xl font-black text-weedyDark uppercase tracking-tight">Mis Pedidos Agendados</h2>
            </div>

            @if (session()->has('user_id'))
                @if (count($pedidos) > 0)
                    @foreach ($pedidos as $ped)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-4 mb-4 gap-2">
                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Orden de Pedido</span>
                                    <h4 class="font-black text-weedyDark text-lg font-mono">{{ $ped->idPedido }}</h4>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">📅 {{ date('d/m/Y - h:i A', strtotime($ped->updated_at)) }}</span>
                                    <span class="px-3 py-1 rounded-lg text-xs font-black uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $ped->estadoEnvio }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                <div class="md:col-span-7">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block mb-2">Productos Comprados</span>
                                    <div class="text-sm font-medium text-gray-700 bg-gray-50 p-3.5 rounded-xl border border-gray-100 leading-relaxed">
                                        {!! $ped->productos_detalle !!}
                                    </div>
                                </div>
                                
                                <div class="md:col-span-5 space-y-3">
                                    <div>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block">Dirección de Envío</span>
                                        <p class="text-xs font-bold text-weedyDark mt-0.5">📍 {{ $ped->direccionEntrega }}</p>
                                    </div>

                                    <div>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block">Número de Tracking</span>
                                        <p class="text-xs font-mono font-bold text-weedyGreen">🚚 {{ $ped->trackingNumber }}</p>
                                    </div>

                                    @if (!empty($ped->notas))
                                        <div>
                                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block">Método de Pago</span>
                                            <p class="text-[11px] font-semibold text-gray-500">💳 {{ $ped->notas }}</p>
                                        </div>
                                    @endif

                                    <div class="border-t border-gray-100 pt-2 flex justify-between items-center">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Monto Total:</span>
                                        <span class="text-xl font-black text-weedyDark">${{ number_format($ped->total_pedido, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center text-gray-400 font-medium italic">
                        📦 Aún no has realizado ningún pedido en la tienda.
                    </div>
                @endif
            @else
                <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center text-gray-400 font-medium italic">
                    🔒 Por favor, <a href="{{ url('/login') }}" class="text-weedyGreen font-bold underline">inicia sesión</a> para consultar el historial de tus pedidos.
                </div>
            @endif
        </div>

    </main>

    <!-- MODAL DE CARRITO DE COMPRAS CON PASARELA VISA / MASTERCARD -->
    <div id="modal-carrito" class="fixed inset-0 bg-black/50 z-50 flex justify-end hidden transition-opacity">
        <div class="bg-white w-full max-w-md h-full shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-black text-weedyDark uppercase tracking-tight flex items-center gap-2">
                        <span>🛒</span> Carrito de Compras
                    </h3>
                    <button onclick="toggleModalCarrito()" class="text-gray-400 hover:text-weedyRed font-bold text-xl p-1">✕</button>
                </div>

                <!-- Lista de Ítems -->
                <div id="lista-carrito" class="space-y-3 max-h-[35vh] overflow-y-auto pr-1 mb-4"></div>

                <!-- Formulario de Entrega y Pago -->
                <div id="seccion-pago" class="space-y-3 border-t border-gray-100 pt-3 hidden">
                    <div>
                        <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Dirección de Entrega</label>
                        <input type="text" id="direccion-entrega" placeholder="Ej: Av. Bolívar, Res. Las Palmeras, Apto 4B" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-xs bg-gray-50 font-medium focus:outline-none focus:ring-2 focus:ring-weedyGreen">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Tarjeta de Crédito (Visa / Mastercard)</label>
                            <span class="text-xs">💳 🇺🇸</span>
                        </div>
                        <input type="text" id="card-number" maxlength="19" placeholder="4532 •••• •••• 8892" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-xs bg-gray-50 font-mono font-medium focus:outline-none focus:ring-2 focus:ring-weedyGreen">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Expiración</label>
                            <input type="text" id="card-exp" maxlength="5" placeholder="MM/AA" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-xs bg-gray-50 font-mono font-medium focus:outline-none focus:ring-2 focus:ring-weedyGreen text-center">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">CVC / CVV</label>
                            <input type="password" id="card-cvc" maxlength="4" placeholder="123" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-xs bg-gray-50 font-mono font-medium focus:outline-none focus:ring-2 focus:ring-weedyGreen text-center">
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4 mt-auto">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 font-bold text-sm">Total a Pagar:</span>
                    <span id="total-carrito" class="text-2xl font-black text-weedyDark">$0.00</span>
                </div>

                @if (session()->has('user_id'))
                    <button onclick="procesarCompra()" id="btn-comprar" class="w-full bg-weedyRed hover:bg-red-800 text-white font-black text-sm uppercase tracking-wider py-3 rounded-xl transition shadow-md">
                        Pagar y Confirmar Pedido
                    </button>
                @else
                    <a href="{{ url('/login') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-xs uppercase tracking-wider py-3 rounded-xl transition shadow-sm text-center block">
                        Ingresa para Comprar
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-weedyDark text-gray-400 border-t border-gray-800 py-12 text-center text-xs mt-auto">
        <p class="font-black text-white text-xl mb-4 tracking-widest uppercase">Weedy<span class="text-weedyGreen">.</span></p>
        <p class="text-gray-500">© 2026 Weedy. Distribuidor Autorizado de Cannabis Medicinal.</p>
    </footer>

    <!-- Lógica JavaScript -->
    <script>
        const tabCatalogo = document.getElementById('tab-catalogo');
        const tabPedidos = document.getElementById('tab-pedidos');
        const panelCatalogo = document.getElementById('panel-catalogo');
        const panelPedidos = document.getElementById('panel-pedidos');

        tabCatalogo.addEventListener('click', () => {
            tabCatalogo.className = "border-b-2 border-weedyGreen text-weedyGreen px-6 py-2.5 transition flex items-center gap-2";
            tabPedidos.className = "border-b-2 border-transparent text-gray-400 hover:text-gray-600 px-6 py-2.5 transition flex items-center gap-2";
            panelCatalogo.classList.remove('hidden');
            panelPedidos.classList.add('hidden');
        });

        tabPedidos.addEventListener('click', () => {
            tabPedidos.className = "border-b-2 border-weedyGreen text-weedyGreen px-6 py-2.5 transition flex items-center gap-2";
            tabCatalogo.className = "border-b-2 border-transparent text-gray-400 hover:text-gray-600 px-6 py-2.5 transition flex items-center gap-2";
            panelPedidos.classList.remove('hidden');
            panelCatalogo.classList.add('hidden');
        });

        let carrito = [];

        function toggleModalCarrito() {
            document.getElementById('modal-carrito').classList.toggle('hidden');
        }

        function mostrarToast(mensaje) {
            const toast = document.getElementById('toast-notif');
            document.getElementById('toast-mensaje').textContent = mensaje;
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 2500);
        }

        function agregarAlCarrito(id, nombre, precio, maxStock, imagen) {
            const cantInput = document.getElementById(`cant-${id}`);
            const cantidad = parseInt(cantInput.value) || 1;

            if (cantidad > maxStock) {
                alert(`Solo hay ${maxStock} unidades disponibles en stock.`);
                return;
            }

            const indice = carrito.findIndex(item => item.id === id);
            if (indice > -1) {
                carrito[indice].cantidad += cantidad;
            } else {
                carrito.push({ id, nombre, precio, cantidad, maxStock, imagen });
            }

            actualizarCarritoUI();
            mostrarToast(`Añadido: ${nombre} (x${cantidad})`);
        }

        function eliminarDelCarrito(id) {
            carrito = carrito.filter(item => item.id !== id);
            actualizarCarritoUI();
        }

        function actualizarCarritoUI() {
            const lista = document.getElementById('lista-carrito');
            const totalEl = document.getElementById('total-carrito');
            const badge = document.getElementById('badge-carrito');
            const seccionPago = document.getElementById('seccion-pago');
            
            lista.innerHTML = "";
            let total = 0;
            let totalItems = 0;

            if (carrito.length === 0) {
                lista.innerHTML = "<p class='text-gray-400 text-xs italic text-center py-8'>Tu carrito está vacío.</p>";
                seccionPago.classList.add('hidden');
            } else {
                seccionPago.classList.remove('hidden');
                carrito.forEach(item => {
                    const subtotal = item.precio * item.cantidad;
                    total += subtotal;
                    totalItems += item.cantidad;

                    lista.innerHTML += `
                        <div class="flex items-center justify-between bg-gray-50 p-2.5 rounded-xl border border-gray-100 gap-3">
                            <img src="${item.imagen}" class="w-12 h-12 object-cover rounded-lg border border-gray-200 shrink-0">
                            <div class="flex-grow pr-2">
                                <h5 class="font-bold text-xs text-weedyDark line-clamp-1">${item.nombre}</h5>
                                <p class="text-[11px] text-gray-500 font-medium">$${item.precio.toFixed(2)} x ${item.cantidad} = <span class="font-bold text-weedyDark">$${subtotal.toFixed(2)}</span></p>
                            </div>
                            <button onclick="eliminarDelCarrito('${item.id}')" class="text-red-500 hover:text-red-700 text-xs font-bold p-1">✕</button>
                        </div>
                    `;
                });
            }

            totalEl.textContent = `$${total.toFixed(2)}`;
            
            if (totalItems > 0) {
                badge.textContent = totalItems;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        document.getElementById('card-number').addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim();
        });

        document.getElementById('card-exp').addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').replace(/^(\d{2})(\d)/, '$1/$2');
        });

        function procesarCompra() {
            if (carrito.length === 0) {
                alert("El carrito está vacío.");
                return;
            }

            const direccion = document.getElementById('direccion-entrega').value.trim();
            const cardNum = document.getElementById('card-number').value.trim();
            const cardExp = document.getElementById('card-exp').value.trim();
            const cardCvc = document.getElementById('card-cvc').value.trim();

            if (!direccion) {
                alert("Por favor, ingresa una dirección de entrega.");
                return;
            }

            if (!cardNum || !cardExp || !cardCvc) {
                alert("Por favor, completa los datos de tu tarjeta Visa / Mastercard.");
                return;
            }

            const formData = new FormData();
            formData.append('direccion', direccion);
            formData.append('num_tarjeta', cardNum);
            formData.append('exp_tarjeta', cardExp);
            formData.append('cvc_tarjeta', cardCvc);
            formData.append('carrito', JSON.stringify(carrito));

            // Token CSRF obligatorio en Laravel para peticiones POST vía Fetch
            fetch("{{ url('/procesar-pedido') }}", { 
                method: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData 
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(`¡Pago Aprobado!\nNúmero de Tracking: ${data.tracking}`);
                    carrito = [];
                    actualizarCarritoUI();
                    toggleModalCarrito();
                    location.reload();
                } else {
                    alert(`Error: ${data.message}`);
                }
            });
        }

        const contenedor = document.getElementById('contenedor-productos');
        const formFiltros = document.getElementById('form-filtros');
        const inputBusqueda = document.getElementById('input-busqueda');
        const precioMin = document.getElementById('precio-min');
        const precioMax = document.getElementById('precio-max');
        let temporizadorFiltro;

        if(inputBusqueda) {
            inputBusqueda.addEventListener('keydown', (e) => { if (e.key === 'Enter') e.preventDefault(); });
        }

        function actualizarCatalogo() {
            if(!contenedor) return;

            const minVal = parseFloat(precioMin.value);
            const maxVal = parseFloat(precioMax.value);

            if (!isNaN(minVal) && !isNaN(maxVal) && minVal > maxVal) {
                contenedor.innerHTML = "<p class='text-amber-600 text-sm text-center col-span-2 py-10 font-semibold'>⚠️ El precio mínimo no puede ser mayor que el máximo.</p>";
                return; 
            }

            contenedor.classList.add('opacity-40', 'pointer-events-none');
            clearTimeout(temporizadorFiltro);

            temporizadorFiltro = setTimeout(() => {
                const formData = new FormData(formFiltros);
                formData.append('busqueda', inputBusqueda.value.trim());
                
                fetch("{{ url('/filtrar-productos') }}", { 
                    method: 'POST', 
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData 
                })
                .then(r => r.text())
                .then(html => {
                    contenedor.classList.remove('opacity-40', 'pointer-events-none');
                    contenedor.innerHTML = html;
                });
            }, 400);
        }

        if(formFiltros) formFiltros.addEventListener('change', actualizarCatalogo);
        if(inputBusqueda) inputBusqueda.addEventListener('input', actualizarCatalogo);
        if(precioMin) precioMin.addEventListener('input', actualizarCatalogo);
        if(precioMax) precioMax.addEventListener('input', actualizarCatalogo);

        actualizarCatalogo();
    </script>
</body>
</html>