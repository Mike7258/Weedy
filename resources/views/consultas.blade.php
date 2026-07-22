<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weedy - Consultas Clínicas</title>
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

    <!-- Navbar Weedy Dinámico -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <span class="text-2xl font-black text-weedyRed tracking-tight">Weedy<span class="text-weedyGreen">.</span></span>
                <div class="hidden md:flex space-x-6 text-sm font-bold text-gray-500">
                    <a href="{{ url('/') }}" class="hover:text-weedyRed pb-5 pt-5 transition">Inicio</a>
                    <a href="{{ url('/tienda') }}" class="hover:text-weedyRed pb-5 pt-5 transition">Tienda</a>
                    <a href="{{ url('/consultas') }}" class="text-weedyRed border-b-2 border-weedyRed pb-5 pt-5">Consultas</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="Buscar especialista..." class="border border-gray-300 rounded-full px-4 py-1.5 text-sm bg-gray-50 w-64 focus:outline-none focus:ring-2 focus:ring-weedyGreen">
                </div>
                <span class="text-gray-600 hover:text-weedyRed cursor-pointer transition text-xl p-1.5 hover:bg-gray-100 rounded-full">🛒</span>
                
                @if ($usuarioLogueado)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-weedyGreen text-white flex items-center justify-center font-bold text-sm shadow-inner select-none" title="{{ $nombreCompleto }}">
                            {{ $inicialesUsuario }}
                        </div>
                        <a href="{{ url('/logout') }}" class="text-xs font-bold text-gray-400 hover:text-weedyRed transition border-l border-gray-200 pl-3">
                            Cerrar Sesión
                        </a>
                    </div>
                @else
                    <a href="{{ url('/login') }}" class="bg-weedyGreen hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm">
                        Iniciar Sesión
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">
        <div class="mb-6">
            <h2 class="text-3xl font-black text-weedyDark uppercase tracking-tight flex items-center gap-3">
                <span class="w-6 h-1 bg-weedyRed rounded-full"></span> Telemedicina Especializada
            </h2>
        </div>

        <!-- Selector de Pestañas Interactivas (Tabs) -->
        <div class="flex border-b border-gray-200 mb-6 text-sm font-bold">
            <button id="tab-especialistas" class="border-b-2 border-weedyGreen text-weedyGreen px-6 py-2.5 transition flex items-center gap-2 cursor-pointer">
                <span>👨‍⚕️</span> Especialistas Disponibles
            </button>
            <button id="tab-citas" class="border-b-2 border-transparent text-gray-400 hover:text-gray-600 px-6 py-2.5 transition flex items-center gap-2 cursor-pointer">
                <span>📅</span> Mis Citas Agendadas
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- PANEL IZQUIERDO MUTABLE -->
            <section class="lg:col-span-7">
                
                <!-- PESTAÑA 1: Especialistas Disponibles -->
                <div id="panel-especialistas" class="space-y-4">
                    @if (count($medicos) > 0)
                        @foreach ($medicos as $medico)
                            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row justify-between items-center gap-4 card-medico" data-id="{{ $medico->idUsuario }}" data-nombre="{{ $medico->nombreCompleto }}">
                                <div class="flex gap-4 w-full sm:w-auto">
                                    <div class="w-16 h-16 rounded-full bg-green-50 border border-weedyGreen flex items-center justify-center text-2xl shadow-inner shrink-0 text-weedyGreen">👨‍⚕️</div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-extrabold text-weedyDark text-lg tracking-tight">{{ $medico->nombreCompleto }}</h4>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-emerald-800 border border-green-200 uppercase tracking-wide">Activo</span>
                                        </div>
                                        <p class="text-weedyGreen text-xs font-bold uppercase tracking-wider mt-0.5">{{ $medico->especialidad }}</p>
                                        <p class="text-gray-400 text-[11px] font-medium mt-1">Licencia Profesional: <span class="text-gray-600 font-mono">{{ $medico->numeroLicencia }}</span></p>
                                        <p class="text-gray-500 text-xs mt-2.5 flex items-center gap-1.5 font-medium bg-gray-50 px-3 py-2 rounded-xl border border-gray-100 inline-block">
                                            <span>📅</span> <span class="text-gray-600 font-bold">Disponibilidad:</span> {{ $medico->agendaDisponible }}
                                        </p>
                                    </div>
                                </div>
                                <div class="shrink-0 w-full sm:w-auto">
                                    @if ($usuarioLogueado)
                                        <button type="button" class="btn-seleccionar-medico bg-weedyGreen hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-sm w-full text-center cursor-pointer">Agendar Cita</button>
                                    @else
                                        <a href="{{ url('/login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm w-full text-center block">Ingresa para Agendar</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- PESTAÑA 2: Mis Citas Agendadas -->
                <div id="panel-citas" class="space-y-4 hidden">
                    @if ($usuarioLogueado)
                        @if (count($citas) > 0)
                            @foreach ($citas as $cita)
                                @php
                                    $timestamp = strtotime($cita->fechaHora);
                                    $horaFormateada = date('h:i A', $timestamp);
                                @endphp
                                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row justify-between items-center gap-4">
                                    <div class="flex gap-4 w-full sm:w-auto">
                                        <div class="w-14 h-14 rounded-xl bg-gray-50 border border-gray-200 flex flex-col items-center justify-center text-gray-500 shrink-0">
                                            <span class="text-lg font-black text-weedyDark">{{ date('d', $timestamp) }}</span>
                                            <span class="text-[9px] font-bold uppercase tracking-wider text-gray-400">{{ date('M', $timestamp) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-weedyDark text-base tracking-tight">Consulta con {{ $cita->medicoNombre }}</h4>
                                            <p class="text-weedyGreen text-xs font-bold uppercase tracking-wider mt-0.5">{{ $cita->especialidad }}</p>
                                            <p class="text-gray-500 text-xs mt-1.5 font-medium">
                                                🕒 Bloque: <span class="text-gray-700 font-bold">{{ $horaFormateada }}</span> | Estado: 
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-amber-50 text-amber-700 border border-amber-200">{{ $cita->estado }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="shrink-0 w-full sm:w-auto">
                                        <a href="{{ $cita->linkVideollamada }}" target="_blank" class="bg-weedyDark hover:bg-stone-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm w-full text-center inline-block">
                                            🎥 Entrar al Meet
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-white border border-gray-200 rounded-2xl p-10 text-center text-gray-400 font-medium italic">
                                📅 Aún no tienes citas agendadas en tu historial clínico.
                            </div>
                        @endif
                    @else
                        <div class="bg-white border border-gray-200 rounded-2xl p-10 text-center text-gray-400 font-medium italic">
                            🔒 Por favor, <a href="{{ url('/login') }}" class="text-weedyGreen font-bold underline">inicia sesión</a> para visualizar tus citas clínicas.
                        </div>
                    @endif
                </div>
            </section>

            <!-- PANEL DERECHO: Formulario Programar -->
            <aside class="lg:col-span-5 space-y-6">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm sticky top-24">
                    <h3 class="text-lg font-black text-weedyDark uppercase tracking-wide border-b border-gray-100 pb-3 mb-4">Programar una Sesión</h3>
                    
                    <div id="contenedor-alerta" class="hidden mb-4 p-3.5 rounded-xl text-xs font-bold border"></div>

                    @if ($usuarioLogueado)
                        <form id="form-cita" class="space-y-4">
                            @csrf
                            <input type="hidden" name="id_medico" id="id-medico-input">
                            <input type="hidden" name="hora_consulta" id="hora-consulta-input">

                            <div>
                                <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">1. Médico Especialista</label>
                                <div id="medico-seleccionado-txt" class="w-full border border-dashed border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-400 font-semibold italic">
                                    Selecciona un especialista de la izquierda...
                                </div>
                            </div>

                            <div>
                                <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">2. Seleccionar Fecha</label>
                                <input type="date" name="fecha_consulta" id="fecha-input" disabled class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed font-medium focus:outline-none">
                                <span id="label-dias-info" class="text-[11px] text-amber-600 font-bold mt-1.5 block hidden"></span>
                            </div>

                            <div>
                                <label class="text-[11px] font-bold text-gray-400 block mb-1 uppercase tracking-wide">Motivo de Consulta</label>
                                <select name="motivo_consulta" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-weedyGreen text-gray-700 font-medium">
                                    <option value="Evaluación y Primera Cita">Evaluación y Primera Cita</option>
                                    <option value="Renovación de Récipe Digital">Renovación de Récipe Digital</option>
                                    <option value="Ajuste de Dosificación CBD/THC">Ajuste de Dosificación CBD/THC</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[11px] font-bold text-gray-400 block mb-2 uppercase tracking-wide">3. Horarios Disponibles</label>
                                <div class="grid grid-cols-2 gap-2" id="grid-horarios">
                                    <p class="text-xs text-gray-400 italic col-span-2 py-2">Elige un día válido para calcular las horas...</p>
                                </div>
                            </div>

                            <button type="submit" id="btn-confirmar" disabled class="w-full bg-gray-300 text-gray-500 font-black text-sm uppercase tracking-wider py-3 rounded-xl cursor-not-allowed transition shadow-sm mt-2">
                                Confirmar Cita Médica
                            </button>
                        </form>
                    @else
                        <div class="text-center py-6">
                            <p class="text-sm font-medium text-gray-400 mb-4">Debes estar autenticado para agendar una sesión médica.</p>
                            <a href="{{ url('/login') }}" class="w-full inline-block bg-weedyGreen hover:bg-emerald-800 text-white font-black text-xs uppercase tracking-wider py-3 rounded-xl transition text-center shadow-sm">
                                Ir al Login
                            </a>
                        </div>
                    @endif
                </div>
            </aside>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-weedyDark text-gray-400 border-t border-gray-800 py-12 text-center text-xs mt-auto">
        <p class="font-black text-white text-xl mb-4 tracking-widest uppercase">Weedy<span class="text-weedyGreen">.</span></p>
        <p class="text-gray-500">© 2026 Weedy. Distribuidor Autorizado de Cannabis Medicinal.</p>
    </footer>

    <!-- Lógica de Pestañas e Interactividad Secundaria -->
    <script>
        const formCita = document.getElementById('form-cita');
        const idMedicoInput = document.getElementById('id-medico-input');
        const horaConsultaInput = document.getElementById('hora-consulta-input');
        const fechaInput = document.getElementById('fecha-input');
        const medicoTxt = document.getElementById('medico-seleccionado-txt');
        const gridHorarios = document.getElementById('grid-horarios');
        const btnConfirmar = document.getElementById('btn-confirmar');
        const labelDiasInfo = document.getElementById('label-dias-info');
        const contenedorAlerta = document.getElementById('contenedor-alerta');

        const tabEspecialistas = document.getElementById('tab-especialistas');
        const tabCitas = document.getElementById('tab-citas');
        const panelEspecialistas = document.getElementById('panel-especialistas');
        const panelCitas = document.getElementById('panel-citas');

        const mapeoDias = {1: 'Lunes', 2: 'Martes', 3: 'Miércoles', 4: 'Jueves', 5: 'Viernes'};
        let diasPermitidosDoctor = [];

        if (fechaInput) {
            const hoyObj = new Date();
            const hoyStr = hoyObj.toISOString().split('T')[0];
            fechaInput.setAttribute('min', hoyStr);

            hoyObj.setMonth(hoyObj.getMonth() + 3);
            const maxStr = hoyObj.toISOString().split('T')[0];
            fechaInput.setAttribute('max', maxStr);
        }

        // Control de Pestañas
        tabEspecialistas.addEventListener('click', () => {
            tabEspecialistas.className = "border-b-2 border-weedyGreen text-weedyGreen px-6 py-2.5 transition flex items-center gap-2 cursor-pointer";
            tabCitas.className = "border-b-2 border-transparent text-gray-400 hover:text-gray-600 px-6 py-2.5 transition flex items-center gap-2 cursor-pointer";
            panelEspecialistas.classList.remove('hidden');
            panelCitas.classList.add('hidden');
        });

        tabCitas.addEventListener('click', () => {
            tabCitas.className = "border-b-2 border-weedyGreen text-weedyGreen px-6 py-2.5 transition flex items-center gap-2 cursor-pointer";
            tabEspecialistas.className = "border-b-2 border-transparent text-gray-400 hover:text-gray-600 px-6 py-2.5 transition flex items-center gap-2 cursor-pointer";
            panelCitas.classList.remove('hidden');
            panelEspecialistas.classList.add('hidden');
        });

        // Selección de médicos
        document.querySelectorAll('.card-medico').forEach(tarjeta => {
            const btnSel = tarjeta.querySelector('.btn-seleccionar-medico');
            if (btnSel) {
                btnSel.addEventListener('click', () => {
                    const idMed = tarjeta.getAttribute('data-id');
                    const nombreMed = tarjeta.getAttribute('data-nombre');

                    idMedicoInput.value = idMed;
                    horaConsultaInput.value = "";
                    fechaInput.value = "";
                    
                    medicoTxt.textContent = `🩺 Seleccionado: ${nombreMed}`;
                    medicoTxt.className = "w-full border border-weedyGreen rounded-xl px-4 py-2.5 text-sm bg-green-50/50 text-weedyGreen font-bold shadow-sm";

                    fechaInput.disabled = false;
                    fechaInput.className = "w-full border border-gray-300 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-weedyGreen cursor-pointer";
                    gridHorarios.innerHTML = '<p class="text-xs text-gray-400 italic col-span-2 py-2">Por favor, selecciona una fecha...</p>';
                    
                    btnConfirmar.disabled = true;
                    btnConfirmar.className = "w-full bg-gray-300 text-gray-500 font-black text-sm uppercase tracking-wider py-3 rounded-xl cursor-not-allowed transition shadow-sm mt-2";

                    fetch(`/obtener-disponibilidad?id_medico=${idMed}`)
                    .then(r => r.json())
                    .then(data => {
                        diasPermitidosDoctor = data.diasPermitidos;
                        const textoDias = diasPermitidosDoctor.map(d => mapeoDias[d]).join(', ');
                        labelDiasInfo.textContent = `ℹ️ El doctor solo atiende los días: ${textoDias}`;
                        labelDiasInfo.className = "text-[11px] text-weedyGreen font-bold mt-1.5 block";
                    });
                });
            }
        });

        // Cambio de fecha y renderizado dinámico
        if (fechaInput) {
            fechaInput.addEventListener('change', () => {
                const idMed = idMedicoInput.value;
                const fechaSel = fechaInput.value;
                if(!idMed || !fechaSel) return;

                const dateObj = new Date(fechaSel + 'T00:00:00');
                const diaSemana = dateObj.getDay() === 0 ? 7 : dateObj.getDay();

                if (!diasPermitidosDoctor.includes(diaSemana)) {
                    fechaInput.value = "";
                    labelDiasInfo.textContent = `⚠️ Fecha no válida. Por favor elige un día que coincida con la agenda del doctor.`;
                    labelDiasInfo.className = "text-[11px] text-amber-600 font-bold mt-1.5 block animate-pulse";
                    gridHorarios.innerHTML = '<p class="text-xs text-gray-400 italic col-span-2 py-2">Por favor, selecciona una fecha válida...</p>';
                    return;
                }

                const textoDias = diasPermitidosDoctor.map(d => mapeoDias[d]).join(', ');
                labelDiasInfo.textContent = `✅ Día de atención correcto (${textoDias})`;
                labelDiasInfo.className = "text-[11px] text-emerald-600 font-bold mt-1.5 block";

                gridHorarios.innerHTML = '<p class="text-xs text-gray-400 italic col-span-2 py-2">Calculando bloques horarios...</p>';

                fetch(`/obtener-disponibilidad?id_medico=${idMed}&fecha=${fechaSel}`)
                .then(r => r.json())
                .then(data => {
                    gridHorarios.innerHTML = "";
                    data.horas.forEach(h => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.setAttribute('data-value', h.valor);
                        
                        if(h.ocupada) {
                            btn.className = "border border-gray-100 rounded-xl py-2.5 text-xs font-bold text-gray-300 bg-gray-100 cursor-not-allowed text-center";
                            btn.textContent = `${h.display} (Ocupado)`;
                            btn.disabled = true;
                        } else {
                            btn.className = "btn-hora border border-gray-200 rounded-xl py-2.5 text-xs font-bold text-gray-600 bg-gray-50 hover:border-weedyGreen hover:text-weedyGreen transition text-center cursor-pointer";
                            btn.textContent = h.display;
                            
                            btn.addEventListener('click', () => {
                                document.querySelectorAll('.btn-hora').forEach(b => {
                                    b.className = "btn-hora border border-gray-200 rounded-xl py-2.5 text-xs font-bold text-gray-600 bg-gray-50 hover:border-weedyGreen hover:text-weedyGreen transition text-center cursor-pointer";
                                });
                                btn.className = "btn-hora border-2 border-weedyGreen rounded-xl py-2.5 text-xs font-black text-weedyGreen bg-green-50/50 transition text-center shadow-sm";
                                horaConsultaInput.value = h.valor;

                                btnConfirmar.disabled = false;
                                btnConfirmar.className = "w-full bg-weedyRed hover:bg-red-800 text-white font-black text-sm uppercase tracking-wider py-3 rounded-xl transition shadow-md mt-2 cursor-pointer";
                            });
                        }
                        gridHorarios.appendChild(btn);
                    });
                });
            });
        }

        // Envío del formulario
        if (formCita) {
            formCita.addEventListener('submit', function(e) {
                e.preventDefault();
                fetch('/guardar-cita', { method: 'POST', body: new FormData(formCita) })
                .then(r => r.json())
                .then(data => {
                    contenedorAlerta.className = "mb-4 p-3.5 rounded-xl text-xs font-bold border block";
                    contenedorAlerta.textContent = data.message;
                    if (data.status === 'success') {
                        contenedorAlerta.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
                        formCita.reset();
                        medicoTxt.textContent = "Selecciona un especialista de la izquierda...";
                        medicoTxt.className = "w-full border border-dashed border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-400 font-semibold italic";
                        fechaInput.disabled = true;
                        fechaInput.className = "w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-100 text-gray-400 cursor-not-allowed font-medium";
                        gridHorarios.innerHTML = '<p class="text-xs text-gray-400 italic col-span-2 py-2">Elige un día válido...</p>';
                        labelDiasInfo.classList.add('hidden');
                        btnConfirmar.disabled = true;
                        btnConfirmar.className = "w-full bg-gray-300 text-gray-500 font-black text-sm uppercase tracking-wider py-3 rounded-xl cursor-not-allowed transition shadow-sm mt-2";
                        
                        setTimeout(() => { location.reload(); }, 1500);
                    } else {
                        contenedorAlerta.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
                    }
                });
            });
        }
    </script>
</body>
</html>