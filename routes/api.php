<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
    ProfileController
};
use App\Http\Controllers\User\{
    BulkDestroyController,
    UserController
};

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

Route::post('/auth/login', LoginController::class);


Route::middleware(['auth:sanctum'])->prefix('auth')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::get('/profile', ProfileController::class);
});

Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::delete('/bulk-destroy', BulkDestroyController::class);
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
});
