<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class)->except(['show']);
Route::get('export-products', [ProductController::class, 'exportProducts']);
Route::get('categories/children', [CategoryController::class, 'getChildren'])->name('categories.children');
Route::get('download-export/{fileName}', [ProductController::class, 'downloadExport']);
Route::get('exported-files', [ProductController::class, 'showExportedFiles'])->name('export.list');
Route::get('download-export/{fileName}', [ProductController::class, 'downloadExport'])->name('export.download');
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

// Route::get('/', function () {
//     return view('welcome');
// });



