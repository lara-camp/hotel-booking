<?php

use App\Http\Controllers\Admin\AvailableRoomController;
use App\Http\Controllers\Admin\PopularRoomTypeController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\PopularRoomTypeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->resource('bookings',BookingController::class)->only(['index', 'create', 'store']);

Route::middleware(['auth', 'admin'])->prefix("admin")->as("admin.")->group(function () {
    Route::get("/", function () {
        return Inertia::render("Dashboard");
    })->name("index");

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post("/profile/image", [ProfileController::class, 'updateProfileImage'])->name("profile.updateProfileImage");

    // Resources
    Route::resource('reservations', ReservationController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('room-types', RoomTypeController::class)->except(['create', 'edit','show']);
    Route::get('/room-types/archives', [RoomTypeController::class, 'archives'])->name('room-types.archives');
    Route::get("/room-types/test", [RoomTypeController::class, "test"])->name("room-types.test");
    Route::patch("/room-types/{room_types}/restore", [RoomTypeController::class, "restore"])->name("room-types.restore");
    Route::delete("/room-types/{room_types}/force-delete", [RoomTypeController::class, "forceDelete"])->name("room-types.force-delete");
    Route::get('/available-rooms', AvailableRoomController::class);
    Route::get('/popular-room-types', PopularRoomTypeController::class);

});

require __DIR__ . '/auth.php';
