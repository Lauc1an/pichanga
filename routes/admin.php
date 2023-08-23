<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\AuthenticatedController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;

use App\Http\Livewire\Pages\Admins\Home as Admins;
use App\Http\Livewire\Pages\Admins\Crud as AdminsCrud;

Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthenticatedController::class, 'create'])->name('panel.login');
        Route::post('login', [AuthenticatedController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('panel.password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('panel.password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('panel.password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('panel.password.update');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', function () {
            return view('admin.home');
        })->name('panel.home');
        Route::post('logout', [AuthenticatedController::class, 'destroy'])->name('panel.logout');


        Route::get('/admins', Admins::class)->name('panel.admins')->middleware('role:admin');
        Route::get('/admins/{id}', AdminsCrud::class)->name('panel.admins.crud')->middleware('role:admin');

        Route::get('/clientes', function () {
            return "users";
        })->name('panel.users');

        Route::get('/comentarios', function () {
            return "comments";
        })->name('panel.comments');

        Route::get('/empresas', function () {
            return "companies";
        })->name('panel.companies');

        Route::get('/reservas', function () {
            return "bookings";
        })->name('panel.bookings');
    });
});
