<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function index()
    {
        $usuarioLogueado = session()->has('user_id');
        $nombreCompleto = "";
        $inicialesUsuario = "";
        $medicos = [];
        $citas = [];

        if ($usuarioLogueado) {
            $userId = session('user_id');
            $user = DB::table('usuarios')->where('idUsuario', $userId)->first();
            if ($user) {
                $nombreCompleto = $user->nombreCompleto;
                $palabras = explode(' ', $nombreCompleto);
                $inicialesUsuario = strtoupper(substr($palabras[0] ?? 'U', 0, 1) . substr($palabras[1] ?? '', 0, 1));
            }

            // Cargar citas del paciente
            $citas = DB::table('citas_telemedicina as c')
                ->join('personal_medico as m', 'c.idMedico', '=', 'm.idUsuario')
                ->join('empleados as e', 'm.idUsuario', '=', 'e.idUsuario')
                ->join('diarios_dosificacion as d', 'c.idCita', '=', 'd.idCita')
                ->where('d.idPaciente', $userId)
                ->select('c.idCita', 'c.fechaHora', 'c.linkVideollamada', 'c.estado', 'e.nombreCompleto as medicoNombre', 'm.especialidad')
                ->orderBy('c.fechaHora', 'DESC')
                ->get();
        }

        // Cargar personal médico
        $medicos = DB::table('personal_medico as m')
            ->join('empleados as e', 'm.idUsuario', '=', 'e.idUsuario')
            ->select('m.idUsuario', 'e.nombreCompleto', 'm.numeroLicencia', 'm.especialidad', 'm.agendaDisponible')
            ->get();

        return view('consultas', compact('usuarioLogueado', 'nombreCompleto', 'inicialesUsuario', 'medicos', 'citas'));
    }

    public function obtenerDisponibilidad(Request $request)
    {
        $idMedico = $request->input('id_medico');
        $fecha = $request->input('fecha');

        // Lógica simulada de días permitidos (ej: [1, 2, 3, 4, 5] -> Lunes a Viernes)
        // Puedes adaptarlo consultando el campo agendaDisponible de tu BD si lo requieres.
        $diasPermitidos = [1, 2, 3, 4, 5]; 

        if (!$fecha) {
            return response()->json(['diasPermitidos' => $diasPermitidos]);
        }

        // Bloques horarios de ejemplo para el día seleccionado
        $horasDisponibles = [
            ['valor' => '09:00:00', 'display' => '09:00 AM', 'ocupada' => false],
            ['valor' => '10:00:00', 'display' => '10:00 AM', 'ocupada' => false],
            ['valor' => '11:00:00', 'display' => '11:00 AM', 'ocupada' => true],
            ['valor' => '14:00:00', 'display' => '02:00 PM', 'ocupada' => false],
            ['valor' => '15:00:00', 'display' => '03:00 PM', 'ocupada' => false],
            ['valor' => '16:00:00', 'display' => '04:00 PM', 'ocupada' => false],
        ];

        return response()->json([
            'diasPermitidos' => $diasPermitidos,
            'horas' => $horasDisponibles
        ]);
    }

    public function guardarCita(Request $request)
    {
        if (!session()->has('user_id')) {
            return response()->json(['status' => 'error', 'message' => 'Debes iniciar sesión.']);
        }

        $idMedico = $request->input('id_medico');
        $fechaConsulta = $request->input('fecha_consulta');
        $horaConsulta = $request->input('hora_consulta');
        $motivo = $request->input('motivo_consulta');

        if (empty($idMedico) || empty($fechaConsulta) || empty($horaConsulta)) {
            return response()->json(['status' => 'error', 'message' => 'Por favor, completa todos los campos requeridos.']);
        }

        try {
            DB::beginTransaction();

            $idCita = "CIT-" . substr(md5(uniqid(rand(), true)), 0, 8);
            $fechaHora = $fechaConsulta . ' ' . $horaConsulta;
            $linkMeet = "https://meet.google.com/abc-defg-hij";

            DB::table('citas_telemedicina')->insert([
                'idCita'           => $idCita,
                'idMedico'         => $idMedico,
                'fechaHora'        => $fechaHora,
                'linkVideollamada' => $linkMeet,
                'estado'           => 'Confirmada',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // Vincular al diario de dosificación del paciente actual
            DB::table('diarios_dosificacion')->insert([
                'idDiario'   => "DIA-" . substr(md5(uniqid(rand(), true)), 0, 8),
                'idPaciente' => session('user_id'),
                'idCita'     => $idCita,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => '¡Cita médica programada con éxito!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Error al guardar la cita: ' . $e->getMessage()
            ]);
        }
    }

    public function adminDashboard()
    {
        // 1. Verificar si hay sesión activa
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Debes iniciar sesión como administrador.');
        }

        $userId = session('user_id');

        // 2. Verificar si el usuario actual es un empleado con rol de Administrador
        $empleado = DB::table('empleados')
            ->where('idUsuario', $userId)
            ->where('rol', 'Administrador')
            ->first();

        if (!$empleado) {
            return redirect('/')->with('error', 'Acceso denegado. No tienes privilegios de administrador.');
        }

        // 3. Cargar datos necesarios para el panel de administración (ej. total de citas, médicos, usuarios)
        $citas = DB::table('citas_telemedicina as c')
            ->join('usuarios as u', 'c.idMedico', '=', 'u.idUsuario')
            ->select('c.*', 'u.nombreCompleto as medicoNombre')
            ->get();

        $medicos = DB::table('personal_medico as m')
            ->join('usuarios as u', 'm.idUsuario', '=', 'u.idUsuario')
            ->select('m.*', 'u.nombreCompleto')
            ->get();

        // Retornar la vista de administración (asegúrate de tener el archivo resources/views/admin.blade.php creado)
        return view('admin', compact('citas', 'medicos'));
    }
}