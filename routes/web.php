<?php

use App\Http\Controllers\CouchDBController;
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

Route::get('/', [CouchDBController::class, 'index']);
// Route::get('users/{id}/edit', [CouchDBController::class, 'edit'])->name('users.edit');
Route::post('users', [CouchDBController::class, 'store'])->name('users.store');
Route::post('users/update', [CouchDBController::class, 'update'])->name('users.update');
Route::get('users/{id}/delete', [CouchDBController::class, 'destroy'])->name('users.destroy');
