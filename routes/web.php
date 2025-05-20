<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AlertSubscriberController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [AnnouncementController::class, 'index'])->name('home');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');

Route::post('/alerts/subscribe', [AlertSubscriberController::class, 'subscribe'])->name('alerts.subscribe');
Route::post('/alerts/unsubscribe', [AlertSubscriberController::class, 'unsubscribe'])->name('alerts.unsubscribe');

// Admin routes
// Admin routes
Route::middleware(['auth', 'role:admin,supervisor'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/announcements', [AnnouncementController::class, 'adminIndex'])->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
        
        // Event routes
        Route::get('/events', [EventController::class, 'adminIndex'])->name('events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/subscribers', [AlertSubscriberController::class, 'adminIndex'])->name('subscribers.index');
        
        // Admin-only routes
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/alerts/send', [AlertSubscriberController::class, 'sendAlert'])->name('alerts.send');
        });
    });
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
