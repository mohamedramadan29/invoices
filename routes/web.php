<?php

use App\Http\Controllers\InvoicesDetailsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
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
    return view('auth.login');
});
Auth::routes();

Route::resource('invoices',InvoicesController::class);

Route::resource('sections',\App\Http\Controllers\SectionsController::class);
Route::resource('products',\App\Http\Controllers\ProductsController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);
Route::get('/invoicesdetails/{id}',[InvoicesDetailsController::class,"edit"]);
Route::get('/openfile/{invoice_number}/{file_name}',[InvoicesDetailsController::class,"openfile"]);
Route::get('/download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,"download"]);
Route::post('/delete_attach/{id}',[InvoicesDetailsController::class,"destroy"]);
Route::get('/{page}', ['App\Http\Controllers\AdminController','index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
