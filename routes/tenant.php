<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Home\HomeController;
use App\Http\Controllers\Admin\Task\TaskController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\UserSettings\AdminController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\WebSiteSettings\RoleController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Admin\WebSiteSettings\SettingsController;
use App\Http\Controllers\Admin\Notification\NotificationController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::controller(AuthController::class)
        ->prefix(LaravelLocalization::setLocale())
        ->group(function () {
            Route::get('/', 'loginForm')
                ->name('auth.loginForm')
                ->middleware('guest:admin');
            Route::post('/login', 'login')
                ->name('auth.login');
            Route::post('/logout', 'logout')
                ->name('auth.logout')
                ->middleware('auth:admin');
            Route::get('/forget-password', 'forgetPasswordForm')
                ->name('auth.forgetPasswordForm')
                ->middleware('guest:admin');
            Route::post('/forget-password', 'forgetPassword')
                ->name('auth.forgetPassword')
                ->middleware('guest:admin');
            Route::get('/reset-password', 'resetPassword')
                ->name('auth.resetPassword')
                ->middleware('guest:admin');
            Route::post('/reset-password-submit', 'resetPasswordSubmit')
                ->name('auth.resetPasswordSubmit')
                ->middleware('guest:admin');
        });

    Route::group([
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'as' => 'admin.',
        'middleware' => [
            'auth:admin',
            'active.admin',
            'localeSessionRedirect',
            'localizationRedirect',
            'localeViewPath',
        ]
    ], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard.index');
        Route::controller(ProfileController::class)
            ->group(function () {
                Route::get('/update-profile', 'index')
                    ->name('profile.index');
                Route::post('/update-profile', 'update')
                    ->name('profile.update');
            });

        Route::controller(AdminController::class)
            ->group(function () {
                Route::get('/admins', 'index')
                    ->name('admins.index')
                    ->middleware('has.permission:admins.view');
                Route::get('/admins-search', 'search')
                    ->name('admins.search')
                    ->middleware('has.permission:admins.view');
                Route::get('/admins-create', 'create')
                    ->name('admins.create')
                    ->middleware('has.permission:admins.create');
                Route::post('/admins-store', 'store')
                    ->name('admins.store')
                    ->middleware('has.permission:admins.create');
                Route::get('/admins/edit/{admin}', 'edit')
                    ->name('admins.edit')
                    ->middleware('has.permission:admins.update', 'not.this.admin');
                Route::post('/admins/update/{admin}', 'update')
                    ->name('admins.update')
                    ->middleware('has.permission:admins.update', 'not.this.admin');
                Route::post('/admins/update-status/{admin}', 'updateStatus')
                    ->name('admins.updateStatus')
                    ->middleware('has.permission:admins.update', 'not.this.admin');
                Route::delete('/admins/delete/{admin}', 'delete')
                    ->name('admins.delete')
                    ->middleware('has.permission:admins.delete', 'not.this.admin');
            });

        Route::controller(TaskController::class)
            ->group(function () {
                Route::get('/tasks', 'index')
                    ->name('tasks.index')
                    ->middleware('has.permission:task.view');
                Route::get('/tasks-show', 'show')
                    ->name('tasks.show')
                    ->middleware('has.permission:task.view');
                Route::get('/tasks-search', 'search')
                    ->name('tasks.search')
                    ->middleware('has.permission:task.view');
                Route::get('/tasks-create', 'create')
                    ->name('tasks.create')
                    ->middleware('has.permission:task.create');
                Route::post('/tasks-store', 'store')
                    ->name('tasks.store')
                    ->middleware('has.permission:task.create');
                Route::get('/tasks/edit/{task}', 'edit')
                    ->name('tasks.edit')
                    ->middleware('has.permission:task.update');
                Route::post('/tasks/update/{task}', 'update')
                    ->name('tasks.update')
                    ->middleware('has.permission:task.update');
                Route::post('/tasks/update-status/{task}', 'updateStatus')
                    ->name('tasks.updateStatus')
                    ->middleware('has.permission:task.update');
                Route::delete('/tasks/delete/{task}', 'delete')
                    ->name('tasks.delete')
                    ->middleware('has.permission:task.delete');
            });

        Route::controller(NotificationController::class)
            ->group(function () {
                Route::get('get-notifications', 'index')
                    ->name('notifications.get');
                Route::get('/all-notifications', 'showAll')
                    ->name('notifications.showAll');
                Route::delete('/delete-all-notifications', 'deleteAll')
                    ->name('notifications.deleteAll');
                Route::delete('/delete-notification/{id}', 'delete')
                    ->name('notifications.delete');
            });

        Route::controller(RoleController::class)
            ->group(function () {
                Route::get('/roles', 'index')
                    ->name('roles.index')
                    ->middleware('has.permission:role.view');
                Route::get('/roles-search', 'search')
                    ->name('roles.search')
                    ->middleware('has.permission:role.view');
                Route::get('/roles/create', 'create')
                    ->name('roles.create')
                    ->middleware('has.permission:role.create');
                Route::post('/roles/store', 'store')
                    ->name('roles.store')
                    ->middleware('has.permission:role.create');
                Route::get('/roles/edit/{role}', 'edit')
                    ->name('roles.edit')
                    ->middleware('has.permission:role.update');
                Route::post('/roles/update/{role}', 'update')
                    ->name('roles.update')
                    ->middleware('has.permission:role.update');
            });

        Route::controller(SettingsController::class)
            ->group(function () {
                Route::get('/settings', 'index')
                    ->name('settings.index')
                    ->middleware('has.permission:settings.update');
                Route::post('/settings-update', 'update')
                    ->name('settings.update')
                    ->middleware('has.permission:settings.update');
            });
    });
});
