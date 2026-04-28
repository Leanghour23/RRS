<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\AuthDemoController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::post('/booking-request', [BookingRequestController::class, 'store'])->name('booking.request');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/login', [AuthDemoController::class, 'login'])->name('login.submit');
    Route::post('/register', [AuthDemoController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthDemoController::class, 'logout'])->name('logout');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/booking', [AdminBookingController::class, 'index'])->name('admin.booking');
    Route::get('/admin/customers', [AdminCustomerController::class, 'index'])->name('admin.customers');
    Route::get('/admin/inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
});

Route::redirect('/dashboard', '/admin/dashboard');
