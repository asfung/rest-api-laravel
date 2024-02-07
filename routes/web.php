<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuotesController;
use App\Http\Controllers\Api\PegawaiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/api/v1/quotes',[QuotesController::class, 'findAll']);
Route::post('/api/v1/quotes',[QuotesController::class, 'addQuote']);
Route::get('/api/v1/quotes/{id}',[QuotesController::class, 'findById']);
Route::put('/api/v1/quotes/{id}',[QuotesController::class, 'updateById']);
Route::delete('/api/v1/quotes/{id}',[QuotesController::class, 'deleteById']);


Route::get('/api/v1/pegawai',[PegawaiController::class, 'findAll']);
Route::post('/api/v1/pegawai',[PegawaiController::class, 'addPegawai']);
Route::get('/api/v1/pegawai/{id}',[PegawaiController::class, 'findById']);
Route::put('/api/v1/pegawai/{id}',[PegawaiController::class, 'updateById']);
Route::delete('/api/v1/pegawai/{id}',[PegawaiController::class, 'deleteById']);

// jwt token
Route::controller(AuthController::class)->group(function () {
  Route::post('auth/login', 'login');
  Route::post('auth/register', 'register');
  Route::post('auth/logout', 'logout');
  Route::post('auth/refresh', 'refresh');
  Route::post('auth/view-profile', 'viewProfile');
});
