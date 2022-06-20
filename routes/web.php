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
Route::post('/order/add', [HomeController::class, 'save'])->name('save');
Route::get('/order/{id}', [HomeController::class, 'delete'])->name('delete');
Route::get('/order/show/{id}', [HomeController::class , 'show'])->name('show');
Route::patch('/order/show/{id}', [HomeController::class , 'update'])->name('update');

Route::get('/create/{id}', [HomeController::class , 'create'])->name('create');
Route::get('/finalize/{id}', [HomeController::class , 'finalize'])->name('finalize');

Route::get('/filter/{status}', [HomeController::class, 'filter'])->name('filter');
Route::get('/search/{number}', [HomeController::class, 'search'])->name('search');
