<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

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



Auth::routes();




Route::middleware(['auth', 'role_check:admin'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('rooms', RoomController::class)->except(['show']);

});

Route::get('/client', [App\Http\Controllers\HomeController::class, 'client'])->name('client');


Route::post('/reserve/{room}', [App\Http\Controllers\HomeController::class, 'reserve'])->name('reserve');

Route::get('/cancel/{id}', [App\Http\Controllers\HomeController::class, 'cancel'])->name('cancel');

Route::put('/change/{id}', [App\Http\Controllers\HomeController::class, 'change'])->name('change');

