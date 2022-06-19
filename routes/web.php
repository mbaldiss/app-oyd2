<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/order/add', [HomeController::class, 'add'])->name('add');

Route::post('/pedido/add', [HomeController::class, 'save'])->name('save');
Route::get('/pedido/{id}', [HomeController::class, 'delete'])->name('destroy');
Route::get('/pedido/show/{id}', [HomeController::class , 'show'])->name('show');
Route::patch('/pedido/update/{id}', [HomeController::class , 'update'])->name('update');
