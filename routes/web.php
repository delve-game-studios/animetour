<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\PlaylistsController;
use App\Http\Controllers\Admin\VideosController;
use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Front\IndexController;
use App\Notifications\VideosUploaded;

/**
 * Auth
 */
$this->middleware([])->prefix('auth')->group(function () {
    $this->get('login', [LoginController::class, 'showLoginForm'])->name('login');
    $this->post('login', [LoginController::class, 'login']);
    $this->post('logout', [LoginController::class, 'logout'])->name('logout');

    $this->get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    $this->post('register', [RegisterController::class, 'register']);

    $this->get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    $this->post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    $this->get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    $this->post('password/reset', [ResetPasswordController::class, 'reset']);

    $this->get('activate', [ActivateAccountController::class, 'activate'])->name('activate');
    $this->post('activate', [ActivateAccountController::class, 'requestNewActivationEmail'])->name('activate.request');
    $this->get('unactivated', [ActivateAccountController::class, 'unactivated'])->name('unactivated');
});

/**
 * Admin
 */
$this->middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    $this->get('/', [DashboardController::class, 'index'])->name('index');
    $this->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    $this->middleware([])->prefix('playlists')->name('playlists.')->group(function () {
        $this->get('', [PlaylistsController::class, 'index'])->name('index');
        $this->get('create', [PlaylistsController::class, 'create'])->name('create');
        $this->get('{playlist}/edit', [PlaylistsController::class, 'edit'])->name('edit');
        $this->get('{playlist}/delete', [PlaylistsController::class, 'delete'])->name('delete');

        $this->post('', [PlaylistsController::class, 'store'])->name('store');
        $this->put('', [PlaylistsController::class, 'update'])->name('update');

        $this->get('{playlist}/videos', [VideosController::class, 'index'])->name('videos');

        $this->middleware([])->prefix('{playlist}/videos')->name('videos.')->group(function () {
            $this->get('import', [VideosController::class, 'import'])->name('import');
            $this->post('{multiple?}', [VideosController::class, 'store'])->name('store');
        });
    });

    $this->get('video/{video}/delete', [VideosController::class, 'delete'])->name('playlists.videos.delete');
    $this->get('video/{video}/verify', [VideosController::class, 'verify'])->name('playlists.videos.verify');

    $this->get('player/{player}', [PlayerController::class, 'index'])->name('player.index');
});

/**
 * Front
 */
$this->middleware([])->name('front.')->group(function () {
    //
});

/**
 * Main route
 */
$this->get('/', [IndexController::class, 'index'])->name('index');

$this->get('/phpinfo', function () {
    if (env('APP_ENV', 'production') === 'local') {
        phpinfo();
    } else {
        abort(404);
    }
});
