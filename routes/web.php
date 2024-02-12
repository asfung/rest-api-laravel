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

Route::middleware('auth:api')->group(function (){
  Route::get('/api/v1/pegawai',[PegawaiController::class, 'findAll']);
  Route::post('/api/v1/pegawai',[PegawaiController::class, 'addPegawai']);
  Route::get('/api/v1/pegawai/{id}',[PegawaiController::class, 'findById']);
  Route::put('/api/v1/pegawai/{id}',[PegawaiController::class, 'updateById']);
  Route::delete('/api/v1/pegawai/{id}',[PegawaiController::class, 'deleteById']);
});

// jwt token
Route::post('/api/auth/login', [AuthController::class, 'login']);
Route::post('/api/auth/register', [AuthController::class, 'register']);
Route::post('/api/auth/logout', [AuthController::class, 'logout']);
Route::post('/api/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/api/auth/view-profile', [AuthController::class, 'viewProfile']);
