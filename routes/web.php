<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgamaController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuotesController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\WilayahIndonesiaController;

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
  // Route::get('/api/v1/pegawai/search',[PegawaiController::class, 'search']);
  // Route::get('/api/v1/pegawai/cari',[PegawaiController::class, 'searchPegawai']);
  Route::post('/api/v1/excel/pegawai/import', [PegawaiController::class, 'importExcel']);
  Route::get('/api/v1/pegawai',[PegawaiController::class, 'findAll']);
  Route::get('/api/v1/excel/pegawai', [PegawaiController::class, 'exportExcel']);
  Route::post('/api/v1/pegawai',[PegawaiController::class, 'addPegawai']);
  Route::get('/api/v1/pegawai/{id}',[PegawaiController::class, 'findById']);
  Route::put('/api/v1/pegawai/{id}',[PegawaiController::class, 'updateById']);
  Route::delete('/api/v1/pegawai/{id}',[PegawaiController::class, 'deleteById']);
  Route::get('/api/v1/pegawais',[PegawaiController::class, 'forcingAll']);
  Route::get('/api/v1/posisi', [CareersController::class, 'addCareer']);
  Route::get('/api/v1/posisi/{id_tree}', [CareersController::class, 'editPosisi']);
});

// jwt token
Route::post('/api/auth/login', [AuthController::class, 'login']);
Route::post('/api/auth/register', [AuthController::class, 'register']);
Route::post('/api/auth/logout', [AuthController::class, 'logout']);
Route::post('/api/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/api/auth/view-profile', [AuthController::class, 'viewProfile']);


Route::get('/api/provinces', [WilayahIndonesiaController::class, 'provinces']);
Route::get('/api/cities/{id}', [WilayahIndonesiaController::class, 'cities']);
Route::get('/api/districts/{id}', [WilayahIndonesiaController::class, 'districts']);
Route::get('/api/villages/{id}', [WilayahIndonesiaController::class, 'villages']);

Route::get('/api/religions', [AgamaController::class, 'findAll']);
Route::get('/api/religion/{id}', [AgamaController::class, 'findById']);

Route::get('/api/careers', [CareersController::class, 'findAll']);
Route::get('/api/career', [CareersController::class, 'findById']);

Route::get('/api/careers_parent', [CareersController::class, 'findAllParent']);

// beta 
Route::get('/api/career_test', [CareersController::class, 'getCareers']);

Route::get('/api/pegawai/mencari', [CareersController::class, 'searchPegawai']);

// test
// Route::get('/api/pegawai/test1/{name}', [CareersController::class, 'getDescendants']);

// Route::get('/software-engineer/{id}', [CareersController::class, 'getSoftwareEngineerWithChildren']);
// Route::get('/test2', [CareersController::class, 'searchPegawaiPosisi']);

// Route::get('/debug', [CareersController::class, 'addCareer']);
// Route::get('/debug2/{id_tree}', [CareersController::class, 'editPosisi']);

// Route::get('/debug3', [PegawaiController::class, 'findAll']);

// Route::get('/all/pegawais',[PegawaiController::class, 'forcingAll']);

// excel
Route::get('debug4/excel', [PegawaiController::class, 'exportExcel']);
// Route::post('excel/import', [PegawaiController::class, 'importPegawaiExcel']);

Route::post('debug6/import', [PegawaiController::class, 'importUser']);
Route::post('debug7/import', [PegawaiController::class, 'importExcel']);
