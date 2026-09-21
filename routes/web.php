<?php

declare(strict_types=1);

use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Users\Index as UsersIndex;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Livewire\Permissions\Index as PermissionsIndex;

Route::view('/', 'welcome')->name('welcome');

Route::post('/language/{locale}', function (string $locale) {
    $supported = ['it', 'en'];

    if (! in_array($locale, $supported)) {
        abort(404);
    }

    auth()->user()->update(['locale' => $locale]);
    app()->setLocale($locale);

    return redirect()->back();
})->middleware('auth')->name('language.switch');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::middleware([RoleMiddleware::using('Admin')])->group(function () {
        Route::get('/users', UsersIndex::class)->name('users.index');
        Route::get('/roles', RolesIndex::class)->name('roles.index');
        Route::get('/permissions', PermissionsIndex::class)->name('permissions.index');
    });

    Route::get('/user/profile', Profile::class)->name('user.profile');
});
