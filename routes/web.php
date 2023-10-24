<?php

use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
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

Route::get("/", [BookingController::class, "index"])->name("index");

Route::middleware(["auth"])->as("user.")->group(function () {
    Route::get("/my-reservations", [BookingController::class, "reservations"])->name("reservations");
    Route::inertia("/profile", "User/Profile")->name("profile");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post("/profile/image", [ProfileController::class, 'updateProfileImage'])->name("profile.updateProfileImage");

    Route::post("/reserve", [BookingController::class, "store"])->name("reserve");
});

Route::middleware('auth')->resource('/', BookingController::class)->only(['create', 'store']);

Route::middleware(['auth', 'admin'])->prefix("admin")->as("admin.")->group(function () {
    Route::get("/", ReportingController::class)->name("index");

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post("/profile/image", [ProfileController::class, 'updateProfileImage'])->name("profile.updateProfileImage");

    // Reservation
    Route::get("/reservations/archives", [ReservationController::class, 'archives'])->name("reservations.archives");
    Route::patch("/reservations/{reservations}/restore", [ReservationController::class, "restore"])->name("reservations.restore");
    Route::delete("/reservations/{reservation}/force-delete", [ReservationController::class, "forceDelete"])->name("reservations.force-delete");
    Route::resource('reservations', ReservationController::class);

    // Room
    Route::get("/rooms/archives", [RoomController::class, "archives"])->name("rooms.archives");
    Route::patch("/rooms/{rooms}/restore", [RoomController::class, "restore"])->name("rooms.restore");
    Route::delete("/rooms/{rooms}/force-delete", [RoomController::class, "forceDelete"])->name("rooms.force-delete");
    Route::resource('rooms', RoomController::class);

    // Room Type
    Route::get('/room-types/archives', [RoomTypeController::class, 'archives'])->name('room-types.archives');
    Route::patch("/room-types/{room_types}/restore", [RoomTypeController::class, "restore"])->name("room-types.restore");
    Route::delete("/room-types/{room_types}/force-delete", [RoomTypeController::class, "forceDelete"])->name("room-types.force-delete");
    Route::resource('room-types', RoomTypeController::class)->except(['create', 'edit', 'show']);
});

require __DIR__ . '/auth.php';
