<?php

use App\Http\Controllers\I18nController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');
});

Route::middleware(['auth'])->prefix('settings')->group(function () {
    Route::redirect('/', '/settings/profile');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('password', [PasswordController::class, 'edit'])->name('user-password.edit');

    Route::put('password', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('user-password.update');

    Route::get('appearance', function () {
        return view('pages.settings.appearance');
    })->name('appearance.edit');
});

Route::middleware(['auth', 'verified'])->name('system-settings.')->prefix('system-settings')->group(function () {
    Route::redirect('/', '/settings/profile');

    Route::get('users/datatable', [UserController::class, 'datatable'])->name('users.datatable');
    Route::resource('users', UserController::class);

    Route::get('permissions/datatable', [PermissionController::class, 'datatable'])->name('permissions.datatable');
    Route::resource('permissions', PermissionController::class);

    Route::get('roles/datatable', [RoleController::class, 'datatable'])->name('roles.datatable');
    Route::resource('roles', RoleController::class);
    Route::post('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    Route::resource('menus', MenuController::class);
});

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['id', 'en'])) {
        abort(400);
    }

    session(['locale' => $locale]);

    return back();
});

Route::get('/lang.js', [I18nController::class, 'langJs'])
    ->name('lang.js');
