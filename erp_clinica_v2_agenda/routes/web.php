<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PacienteAuthController;
use App\Http\Controllers\CartController; // Importar CartController
use App\Models\Producto;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Testimonio;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $productos = Producto::take(6)->get();
    $testimonios = Testimonio::where('es_visible', true)->latest()->take(3)->get();
    $medicosDestacados = Medico::with('especialidad')->take(3)->get();
    $postsRecientes = Post::where('estado', 'publicado')->latest('fecha_publicacion')->take(3)->get();
    return view('welcome', compact('productos', 'testimonios', 'medicosDestacados', 'postsRecientes'));
});

Route::get('/especialidades', function () {
    $especialidades = Especialidad::paginate(9);
    return view('especialidades', compact('especialidades'));
});

Route::get('/productos', function () {
    $productos = Producto::paginate(9);
    return view('productos', compact('productos'));
})->name('productos'); // Nombre de ruta añadido

Route::get('/medicos', function () {
    $medicos = Medico::with('especialidad')->paginate(9);
    return view('medicos', compact('medicos'));
});

Route::get('/medicos/{medico}', function (Medico $medico) {
    return view('medico-perfil', compact('medico'));
})->name('medicos.perfil');

Route::get('/citas/solicitar', [FrontendController::class, 'solicitarCita'])->name('citas.solicitar');
Route::post('/citas/solicitar', [FrontendController::class, 'storeSolicitudCita'])->name('citas.store');

Route::get('/contacto', [FrontendController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [FrontendController::class, 'storeContacto'])->name('contacto.store');

// Rutas del Carrito
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('update-cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::post('checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Rutas del Blog
Route::get('/blog', function () {
    $posts = Post::where('estado', 'publicado')->latest('fecha_publicacion')->paginate(9);
    return view('blog.index', compact('posts'));
})->name('blog.index');

Route::get('/blog/{post:slug}', function (Post $post) {
    return view('blog.show', compact('post'));
})->name('blog.show');

// Rutas del Portal del Paciente
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/login', [PacienteAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PacienteAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [PacienteAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:paciente')->group(function () {
        Route::get('/dashboard', function () {
            $paciente = Auth::guard('paciente')->user();
            $citas = $paciente->citas()->with('medico.especialidad')->orderByDesc('fecha')->orderByDesc('hora')->get();
            $recetas = $paciente->recetas()->with('medico')->latest('fecha_emision')->get();
            $resultados = $paciente->resultados()->latest('fecha_resultado')->get();
            return view('portal.dashboard', compact('citas', 'recetas', 'resultados'));
        })->name('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/consentimientos/{record}/pdf', [PdfController::class, 'descargarConsentimiento'])
        ->name('consentimientos.pdf');

    Route::get('/admin/facturas/{record}/pdf', [PdfController::class, 'descargarFactura'])
        ->name('facturas.pdf');
});
