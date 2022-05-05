<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
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

Route::get('pets/breeds', [PetController::class, 'breeds'])->name('pets.breeds');
Route::get('pets/profile', [PetController::class, 'profile'])->name('pets.profile');

Route::get('reservations/times', [ReservationController::class, 'times'])->name('reservations.times');
Route::get('reservations/between', [ReservationController::class, 'between'])->name('reservations.between');
Route::get('reservations/taken', [ReservationController::class, 'taken'])->name('reservations.taken');

Route::middleware(['guestOrClient'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});

Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('register', [AuthController::class, 'create'])->name('auth.create');
    Route::post('register', [AuthController::class, 'store'])->name('auth.store');
});

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('reservations/pending', [ReservationController::class, 'pending'])->name('reservations.pending');
    Route::get('reservations/pending/year/{year}', [ReservationController::class, 'pendingYear'])->name('reservations.pending.year');
    Route::get('reservations/pending/month/{month}', [ReservationController::class, 'pendingMonth'])->name('reservations.pending.month');
    Route::get('reservations/pending/year/{year}/month/{month}', [ReservationController::class, 'pendingYearAndMonth'])->name('reservations.pending.yearAndMonth');
    Route::post('reservations/pending/print', [ReservationController::class, 'pendingPrint'])->name('reservations.pending.print');

    Route::get('reservations/completed', [ReservationController::class, 'completed'])->name('reservations.completed');
    Route::get('reservations/completed/year/{year}', [ReservationController::class, 'completedYear'])->name('reservations.completed.year');
    Route::get('reservations/completed/month/{month}', [ReservationController::class, 'completedMonth'])->name('reservations.completed.month');
    Route::get('reservations/completed/year/{year}/month/{month}', [ReservationController::class, 'completedYearAndMonth'])->name('reservations.completed.yearAndMonth');
    Route::post('reservations/completed/print', [ReservationController::class, 'completedPrint'])->name('reservations.completed.print');

    Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::put('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::post('reservations/{reservation}/print', [ReservationController::class, 'print'])->name('reservations.print');

    Route::get('pets', [PetController::class, 'index'])->name('pets.index');
    Route::get('pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('pets', [PetController::class, 'store'])->name('pets.store');
    Route::put('pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::get('pets/{pet}', [PetController::class, 'show'])->name('pets.show');

    Route::post('feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::post('doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

    Route::get('staffs', [StaffController::class, 'index'])->name('staffs.index');
    Route::get('staffs/create', [StaffController::class, 'create'])->name('staffs.create');
    Route::post('staffs', [StaffController::class, 'store'])->name('staffs.store');
    Route::delete('staffs/{user}', [StaffController::class, 'destroy'])->name('staffs.destroy');
});
