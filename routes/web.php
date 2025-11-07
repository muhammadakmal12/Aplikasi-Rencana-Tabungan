<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SavingController;

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
    return view('login');
});



Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); 
Route::post('/register', [AuthController::class, 'register']); 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [AuthController::class, 'login']); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('home', [MainController::class, 'home'])->name('home')->middleware('auth');
    Route::get('tabungan', [MainController::class, 'tabungan'])->name('goals.index');
    Route::get('tabungan/tmbh',[MainController::class, 'tmbh'])->name('goals.create');
    Route::post('tabungan',[MainController::class, 'store'])->name('goals.store');
    Route::get('tabungan/edt/{id}',[MainController::class, 'edt'])->name('goals.edit');
    Route::post('tabungan/upd/{id}',[MainController::class, 'upd'])->name('goals.update');
    Route::delete('tabungan/hps/{id}',[MainController::class, 'hps'])->name('goals.destroy');

    Route::get('/setoran{goal_id}', [SavingController::class, 'create'])->name('savings.create');
    Route::post('/setoran{goal_id}', [SavingController::class, 'store'])->name('savings.store');

});