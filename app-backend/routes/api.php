<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth'
], function () {
    // Route::get('me', [AuthController::class, 'me']);
    Route::post('login', [AuthController::class, 'login']);
});
// Route::group([
//     'middleware' => 'auth'
// ], function () {
// Route::group([
//     'prefix' => 'admin'
// ], function () {
Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::get('/user/create', [UserController::class, 'create']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}/update', [UserController::class, 'update']);
Route::delete('/user/{id}/delete', [UserController::class, 'destroy']);
//     });
// });
