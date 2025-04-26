<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PrizeController;

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

Route::get('/', [ParticipantController::class, 'index'])->name('home');
Route::post('/register', [ParticipantController::class, 'store'])->name('participants.store');
Route::get('/register', function () { return view('register'); })->name('participants.register');
Route::get('/ganador', [ParticipantController::class, 'seleccionarGanador'])->name('seleccionarGanador');
Route::get('/export', [ParticipantController::class, 'export'])->name('exportarExcel');
Route::get('/api/participants', [ParticipantController::class, 'apiParticipants'])->name('api.participants');


Route::get('/prizes', [PrizeController::class, 'index'])->name('prizes.index');
Route::post('/prizes', [PrizeController::class, 'store'])->name('prizes.store');

