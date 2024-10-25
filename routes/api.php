<?php

use App\Http\Controllers\Api\JobOfferController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Http\Request; // Cambiado a la clase correcta de Request
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; // Cambiado a la clase correcta para manejo de validaciones
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    // Validación de los datos de entrada
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Buscar el usuario por correo electrónico
    $user = User::where('email', $request->email)->first();

    // Verificar que el usuario exista y la contraseña sea correcta
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Las credenciales son incorrectas.'],
        ]);
    }

    // Generar el token de autenticación
    $token = $user->createToken('token-name')->plainTextToken;

    // Devolver el token como respuesta JSON
    return response()->json(['token' => $token], 200);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Listar usuarios
    Route::get('/users', [UserController::class, 'index']); // Listar usuarios
    Route::post('/users', [UserController::class, 'store']); // Crear un nuevo usuario
    Route::get('/users/{id}', [UserController::class, 'show']); // Mostrar un usuario específico
    Route::put('/users/{id}', [UserController::class, 'update']); // Actualizar un usuario
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Eliminar un usuario
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/job-offers', [JobOfferController::class, 'index']); // Listar ofertas laborales
    Route::post('/job-offers', [JobOfferController::class, 'store']); // Crear una nueva oferta laboral
    Route::get('/job-offers/{id}', [JobOfferController::class, 'show']); // Mostrar una oferta laboral específica
    Route::put('/job-offers/{id}', [JobOfferController::class, 'update']); // Actualizar una oferta laboral
    Route::delete('/job-offers/{id}', [JobOfferController::class, 'destroy']); // Eliminar una oferta laboral
});
