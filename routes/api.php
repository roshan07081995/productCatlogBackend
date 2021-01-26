<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('products', [ApiController::class, 'getAllProducts']);
Route::get('products/{id}', [ApiController::class, 'getProduct']);
Route::post('products', [ApiController::class, 'createProduct']);
Route::put('products/{id}', [ApiController::class, 'updateProduct']);
Route::delete('products/{id}', [ApiController::class, 'deleteProduct']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('user', [AuthController::class, 'getAuthUser']);
