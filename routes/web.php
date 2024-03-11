<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

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

// Define the route for the landing page, pointing to the home view
Route::view('/', 'home');

Auth::routes();

// Other routes remain the same
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware('auth')->group(function () {

    Route::get('/customer', [CustomerController::class, 'index'])->name('customer-list');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customer-create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customer-store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customer-edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customer-update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customer-destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user-list');
	Route::get('/users/create', [UserController::class, 'create'])->name('user-create');
	Route::post('/users', [UserController::class, 'store'])->name('user-store');
	Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user-edit');
	Route::put('/users/{user}', [UserController::class, 'update'])->name('user-update');
	Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user-destroy');
});