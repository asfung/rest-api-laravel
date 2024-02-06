<?php

use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\QuotesController;
use Illuminate\Support\Facades\Route;

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
