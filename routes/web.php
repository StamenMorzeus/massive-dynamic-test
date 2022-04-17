<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientFileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create']);
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    Route::middleware(sprintf('granted.access:%s,%s', \App\Enums\UserRoleEnum::ADMINISTRATOR->value, \App\Enums\UserRoleEnum::SECRETARY->value))->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user_index');
        Route::get('/users/create', [UserController::class, 'create'])->name('user_create');
        Route::post('/users', [UserController::class, 'store'])->name('user_store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user_edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user_update');

        Route::get('/users/client', [UserController::class, 'searchClients'])->name('clients_search');

        Route::get('/clients', [ClientController::class, 'index'])->name('client_index');
        Route::get('/clients/create', [ClientController::class, 'create'])->name('client_create');
        Route::post('/clients', [ClientController::class, 'store'])->name('client_store');
        Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('client_edit');
        Route::put('/clients/{client}', [ClientController::class, 'update'])->name('client_update');

        Route::get('/document/{clientFile}', [ClientFileController::class, 'downloadFile'])->name('download_document');
    });

    Route::middleware(sprintf('granted.access:%s', \App\Enums\UserRoleEnum::ADMINISTRATOR->value))->group(function () {
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user_destroy');

        Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('client_destroy');

        Route::delete('/document/{clientFile}', [ClientFileController::class, 'destroy'])->name('delete_document');
    });

});


require __DIR__.'/auth.php';
