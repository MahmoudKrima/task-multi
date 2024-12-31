<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\AuthController;
use App\Http\Controllers\Api\User\Task\TaskController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::prefix('user')
        ->group(function () {
            Route::controller(AuthController::class)
                ->group(function () {
                    Route::post('/register', 'register');
                    Route::post('/login', 'login');
                    Route::post('/logout', 'logout')
                        ->middleware('auth:api_admin');
                });

                Route::middleware('auth:api_admin')->group(function () {
                    Route::resource('tasks', TaskController::class);
                });
        });
});
