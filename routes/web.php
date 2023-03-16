<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ImportController::class, "fetchData"]);
Route::post('/import/edit', [ImportController::class, "editData"]);
Route::get('/home', [ImportController::class, "fetchData"]);
Route::post('/import', [ImportController::class, "importData"]);
Route::post('/import-edited-data', [ImportController::class, "importEditedData"]);
Route::get('/download-template', [ImportController::class, "downloadTemplate"]);
Route::post('/bulk-action', [ImportController::class, "bulkAction"]);
Route::post('/update-data', [ImportController::class, "updateData"]);