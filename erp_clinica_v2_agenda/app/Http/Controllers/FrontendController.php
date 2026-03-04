<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Para enviar correos
use App\Mail\SolicitudCitaMail; // Necesitaremos crear este Mailable
use App\Mail\ContactoMail; // Necesitaremos crear este Mailable

class FrontendController extends Controller
{
    public function solicitarCita()
    {
        $especialidades = Especialidad::all();
        return view('solicitar-cita', compact('especialidades'));
    }

    public function storeSolicitudCita(Request $request)
    {
        // Validación (la implementaremos en el siguiente paso)
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'especialidad_id' => 'required|exists:especialidades,id',
            'fecha_preferida' => 'required|date|after_or_equal:today',
        ]);

        // Aquí podrías guardar la solicitud en una tabla de 'solicitudes_citas'
        // Por ahora, solo enviaremos un correo.

        // Enviar correo al administrador de la clínica
        Mail::to(config('mail.from.address'))->send(new SolicitudCitaMail($validatedData));

        return redirect()->back()->with('success', 'Tu solicitud de cita ha sido enviada. Nos pondremos en contacto contigo pronto.');
    }

    public function contacto()
    {
        return view('contacto');
    }

    public function storeContacto(Request $request)
    {
        // Validación (la implementaremos en el siguiente paso)
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|min:10',
        ]);

        // Enviar correo al administrador de la clínica
        Mail::to(config('mail.from.address'))->send(new ContactoMail($validatedData));

        return redirect()->back()->with('success', 'Tu mensaje ha sido enviado. Te responderemos a la brevedad posible.');
    }
}
