<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MultiFileController;
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

Route::get('multi-file', [MultiFileController::class, 'index']);
Route::post('ajax-files-upload', [MultiFileController::class, 'store']);
Route::get('getData', [MultiFileController::class, 'show']);
Route::delete('deleteFile/{id}', [MultiFileController::class, 'destroy']);
