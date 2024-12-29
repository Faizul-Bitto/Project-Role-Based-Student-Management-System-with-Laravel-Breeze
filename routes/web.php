<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;

// Home route
Route::get( '/', function () {
    return view( 'pages.home.home-page' );
} );

// Main dashboard route
Route::get( '/dashboard', function () {
    $user = Auth::user();

    if ( $user->hasRole( 'Admin' ) ) {
        return app( DashboardController::class )->adminDashboard();
    } elseif ( $user->hasRole( 'Student' ) ) {
        return app( DashboardController::class )->studentDashboard();
    } elseif ( $user->hasRole( 'Guest' ) ) {
        return app( DashboardController::class )->guestDashboard();
    }

    return redirect( '/' ); // Redirect to home if no role matches
} )->middleware( ['auth', 'verified'] )->name( 'dashboard' );

// Admin routes
Route::middleware( ['auth', 'role:Admin'] )->group( function () {
    Route::get( '/admin/dashboard', [DashboardController::class, 'adminDashboard'] )->name( 'admin.dashboard' );
    Route::get( '/admin/users', [AdminController::class, 'index'] )->name( 'admin.users' );
    Route::get( '/admin/users/create', [AdminController::class, 'create'] )->name( 'admin.users.create' );
    Route::post( '/admin/users', [AdminController::class, 'store'] )->name( 'admin.users.store' );
    Route::get( '/admin/users/{user}/edit', [AdminController::class, 'edit'] )->name( 'admin.users.edit' );
    Route::put( '/admin/users/{user}', [AdminController::class, 'update'] )->name( 'admin.users.update' );
    Route::delete( '/admin/users/{user}', [AdminController::class, 'destroy'] )->name( 'admin.users.destroy' );
} );

// Student routes
Route::middleware( ['auth', 'role:Student'] )->group( function () {
    Route::get( '/student/dashboard', [DashboardController::class, 'studentDashboard'] )->name( 'student.dashboard' );
    Route::get( '/student/dashboard', [StudentController::class, 'index'] )->name( 'student.dashboard.index' );
    Route::get( '/student/guests/create', [StudentController::class, 'create'] )->name( 'student.guests.create' );
    Route::post( '/student/guests', [StudentController::class, 'store'] )->name( 'student.guests.store' );
} );

// Guest routes
Route::middleware( ['auth', 'role:Guest'] )->group( function () {
    Route::get( '/guest/dashboard', [DashboardController::class, 'guestDashboard'] )->name( 'guest.dashboard' );
    Route::get( '/guest/users', [GuestController::class, 'index'] )->name( 'guest.users' );
} );

// Profile routes
Route::middleware( 'auth' )->group( function () {
    Route::get( '/profile', [ProfileController::class, 'edit'] )->name( 'profile.edit' );
    Route::patch( '/profile', [ProfileController::class, 'update'] )->name( 'profile.update' );
    Route::delete( '/profile', [ProfileController::class, 'destroy'] )->name( 'profile.destroy' );
} );

// Authentication routes
require __DIR__ . '/auth.php';
