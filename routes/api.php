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
Route::get('students', [ApiController::class, 'getAllStudents']);
Route::get('students/{id}', [ApiController::class, 'getStudent']);
Route::post('students', [ApiController::class, 'createStudent']);
Route::put('students/{id}', [ApiController::class, 'updateStudent']);
Route::delete('students/{id}', [ApiController::class, 'deleteStudent']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('user', [AuthController::class, 'getAuthUser']);
