<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $inicialesUsuario = "";
        $primerNombre = "";
        $nombreCompleto = "";

        // Si existe la sesión del usuario, procesamos sus datos
        if (session()->has('user_id')) {
            $nombreCompleto = session('user_name');
            
            // Separar las palabras para obtener iniciales y primer nombre
            $palabras = explode(' ', $nombreCompleto);
            $primerNombre = $palabras[0] ?? '';
            
            // Generar las iniciales (Ej: "José Mora" -> "JM")
            $inicial1 = substr($palabras[0] ?? 'U', 0, 1);
            $inicial2 = substr($palabras[1] ?? '', 0, 1);
            $inicialesUsuario = strtoupper($inicial1 . $inicial2);
        }

        // Pasamos las variables procesadas a la vista
        return view('index', compact('inicialesUsuario', 'primerNombre', 'nombreCompleto'));
    }
}