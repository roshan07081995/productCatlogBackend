<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('students', [ApiController::class, 'getAllStudents']);
Route::get('students/{id}', [ApiController::class, 'getStudent']);
Route::post('students', [ApiController::class, 'createStudent']);
Route::put('students/{id}', [ApiController::class, 'updateStudent']);
Route::delete('students/{id}', [ApiController::class, 'deleteStudent']);