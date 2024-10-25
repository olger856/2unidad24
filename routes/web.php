<?php

use App\Http\Controllers\Admin\AdminJobOfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\PostulantJobOfferController;
use App\Http\Controllers\PostulacionesController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\EmpresaJobOfferController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Aquí puedes registrar las rutas web para tu aplicación.
|
*/

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Ruta para el dashboard, accesible solo para usuarios autenticados, verificados y aprobados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'approved'])->name('dashboard');

// Grupo de rutas accesibles solo para usuarios autenticados y aprobados
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para cambiar el estado de aprobación del usuario
    Route::post('/users/{id}/toggle-approval', [UserApprovalController::class, 'toggleApproval'])->name('users.toggleApproval');
});

// Rutas para el administrador (rol 1)
Route::middleware(['auth', 'role:1', 'approved'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Rutas para el CRUD de usuarios
    Route::get('/admin/users/index', [UserController::class, 'indexPostulantes'])->name('admin.users.index'); // Mostrar postulantes
    Route::get('/admin/empresas/index', [UserController::class, 'indexEmpresas'])->name('admin.empresas.index'); // Mostrar empresas
    Route::get('/admin/supervisores/index', [UserController::class, 'indexSupervisores'])->name('admin.supervisores.index'); // Mostrar supervisores
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('/admin/empresas/create', [UserController::class, 'createEmpresa'])->name('admin.empresas.create');
    Route::get('/admin/supervisores/create', [UserController::class, 'createSupervisor'])->name('admin.supervisores.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::get('/admin/empresas/{user}/edit', [UserController::class, 'editEmpresa'])->name('admin.empresas.edit');
    Route::get('/admin/supervisores/{supervisor}/edit', [UserController::class, 'editSupervisor'])->name('admin.supervisores.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::put('/admin/empresas/{user}', [UserController::class, 'updateEmpresa'])->name('admin.empresas.update');
    Route::put('/admin/supervisores/{supervisor}', [UserController::class, 'updateSupervisor'])->name('admin.supervisores.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::delete('/admin/empresas/{user}', [UserController::class, 'destroyEmpresa'])->name('admin.empresas.destroy');
    Route::delete('/admin/supervisores/{supervisor}', [UserController::class, 'destroySupervisor'])->name('admin.supervisores.destroy');
    Route::get('/admin/users/unapproved', [UserApprovalController::class, 'showUnapproved'])->name('admin.users.unapproved');

    // Rutas para el CRUD de ofertas laborales (administrador)
    Route::get('/admin/job_offers', [AdminJobOfferController::class, 'index'])->name('admin.job_offers.index');
    Route::get('/admin/job_offers/create', [AdminJobOfferController::class, 'create'])->name('admin.job_offers.create');
    Route::post('/admin/job_offers', [AdminJobOfferController::class, 'store'])->name('admin.job_offers.store');
    Route::get('/admin/job_offers/{jobOffer}/edit', [AdminJobOfferController::class, 'edit'])->name('admin.job_offers.edit');
    Route::put('/admin/job_offers/{jobOffer}', [AdminJobOfferController::class, 'update'])->name('admin.job_offers.update');
    Route::delete('/admin/job_offers/{jobOffer}', [AdminJobOfferController::class, 'destroy'])->name('admin.job_offers.destroy');

    Route::get('/admin/job_offers/export/{format}', [AdminJobOfferController::class, 'exportAll'])->name('admin.job_offers.export_all');
    Route::get('/admin/job_offers/export/{id}/{format}', [AdminJobOfferController::class, 'export'])->name('admin.job_offers.export');

});

// Rutas para la empresa (rol 2)
Route::middleware(['auth', 'role:2', 'approved'])->group(function () {
    Route::get('/empresa/perfil', function () {
        return view('empresa.perfil');
    })->name('empresa.perfil');

    // Rutas para el CRUD de ofertas laborales
    Route::get('/empresa/ofertas', [JobOfferController::class, 'index'])->name('job_offers.index');
    Route::get('/empresa/ofertas/create', [JobOfferController::class, 'create'])->name('job_offers.create');
    Route::post('/empresa/ofertas', [JobOfferController::class, 'store'])->name('job_offers.store');
    Route::get('/empresa/ofertas/{jobOffer}/edit', [JobOfferController::class, 'edit'])->name('job_offers.edit');
    Route::put('/empresa/ofertas/{jobOffer}', [JobOfferController::class, 'update'])->name('job_offers.update');
    Route::delete('/empresa/ofertas/{jobOffer}', [JobOfferController::class, 'destroy'])->name('job_offers.destroy');

    // Rutas para supervisores (empresa)
    Route::get('/empresa/supervisores/create', [UserController::class, 'createSupervisor'])->name('empresa.supervisores.create');
    Route::post('/empresa/supervisores', [UserController::class, 'storeSupervisor'])->name('empresa.supervisores.store');
    Route::get('/empresa/supervisores', [UserController::class, 'indexSupervisores'])->name('empresa.supervisores.index');
    Route::get('/empresa/supervisores/{supervisor}/edit', [UserController::class, 'editSupervisor'])->name('empresa.supervisores.edit');
    Route::put('/empresa/supervisores/{supervisor}', [UserController::class, 'updateSupervisor'])->name('empresa.supervisores.update');
    Route::delete('/empresa/supervisores/{supervisor}', [UserController::class, 'destroySupervisor'])->name('empresa.supervisores.destroy');

    // Rutas para ver las postulaciones a ofertas laborales
    Route::get('/empresa/ofertas/{jobOffer}/postulantes', [JobOfferController::class, 'showPostulantes'])->name('empresa.ofertas.postulantes');
    Route::get('/empresa/postulaciones', [PostulacionesController::class, 'index'])->name('empresa.postulaciones.index');
    Route::get('/postulaciones/{id}', [PostulacionesController::class, 'show'])->name('postulaciones.show');
    Route::get('postulaciones', [PostulacionesController::class, 'index'])->name('postulaciones.index');
    // Rutas en web.php
    Route::post('postulaciones/{application}/update-status/{status}', [PostulantJobOfferController::class, 'updateStatus'])->name('postulacion.updateStatus');
    Route::post('job-offers/{jobOffer}/reject-all-pending', [PostulantJobOfferController::class, 'rejectAllPending'])->name('postulacion.rejectAllPending');

});

// Rutas para el postulante (rol 3)
Route::middleware(['auth', 'role:3', 'approved'])->group(function () {
    Route::get('/postulante/perfil', function () {
        return view('postulante.perfil');
    })->name('postulante.perfil');

    // Rutas para aplicar a una oferta laboral
    Route::get('/ofertas', [PostulantJobOfferController::class, 'index'])->name('postulante.job_offers.index');
    Route::post('/ofertas/{jobOffer}/apply', [PostulantJobOfferController::class, 'apply'])->name('job_offers.apply');
    Route::get('/ofertas/{jobOffer}', [PostulantJobOfferController::class, 'show'])->name('postulante.job_offers.show');
    Route::post('/ofertas/{jobOffer}/unapply', [PostulantJobOfferController::class, 'unapply'])->name('job_offers.unapply');
    Route::delete('/postulante/ofertas/{jobOffer}/unapply', [PostulantJobOfferController::class, 'unapply'])->name('postulante.unapply');

    // Ruta para ver las postulaciones del usuario autenticado
    Route::get('/postulante/aplicaciones', [PostulantJobOfferController::class, 'aplicaciones'])->name('postulante.aplicaciones');
});

// Rutas para el supervisor (rol 4)
Route::middleware(['auth', 'role:4', 'approved'])->group(function () {
    Route::get('/supervisor/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('supervisor.dashboard');
});

// Ruta para la vista de espera de aprobación
Route::get('/pending-approval', function () {
    return view('pending_approval');
})->name('pending.approval');

// Ruta para cerrar sesión y redirigir a la página principal
Route::post('/logout-and-redirect', function () {
    Auth::logout();
    return redirect('/');
})->name('logout.and.redirect');


// Nueva ruta para mostrar usuarios no aprobados
Route::get('/usuarios-no-aprobados', [UserApprovalController::class, 'showUnapproved'])->name('usuarios.no.aprobados');
Route::get('/export/usuarios-pdf', [ExportController::class, 'exportUsersPDF'])->name('export.users.pdf');
Route::get('/export/empresas-pdf', [ExportController::class, 'exportEmpresasPDF'])->name('export.empresas.pdf');
Route::get('/export/ofertas-pdf', [ExportController::class, 'exportJobOffersToPDF'])->name('export.ofertas.pdf');
Route::get('/export/supervisores-pdf', [ExportController::class, 'exportSupervisoresPDF'])->name('export.supervisores.pdf');
Route::get('/export/postulaciones-pdf', [ExportController::class, 'exportPostulacionesPDF'])->name('export.postulaciones.pdf');
Route::get('/export/Empresapostulaciones-pdf/{jobOffer}', [ExportController::class, 'exportPostulacionesEmpresaPDF'])->name('export.Empresapostulaciones.pdf');

require __DIR__.'/auth.php';
