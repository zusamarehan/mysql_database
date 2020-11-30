<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire;
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

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', Livewire\Dashboard::class)
    ->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/connection/new', Livewire\ConnectionNew::class)
    ->name('connection.new');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/connection/{connection}', Livewire\ConnectionShow::class)
    ->name('connection.show');
