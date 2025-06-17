<?php

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

Route::get('/register', function () {
    return view('register');
});





use App\Http\Controllers\MpesaController;
Route::get('/stkpush', function () {
    return view('stkpush');
})->name('stkpush');

Route::post('/stkpush/initiate', [MpesaController::class, 'initiateStkPush'])->name('mpesa.initiate');







use App\Http\Controllers\TicketController;

Route::get('/generate-ticket', [TicketController::class, 'generateTicket']);
