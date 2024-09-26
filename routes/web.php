<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/edit-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/edit-profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // New route for editing favorites (only for volunteers)
    Route::get('/favorites/edit', [FavoritesController::class, 'edit'])->name('favorites.edit');
    Route::patch('/favorites', [FavoritesController::class, 'update'])->name('favorites.update');
    
    // update organization information -- partials are independent
    Route::patch('/profile/organization', [ProfileController::class, 'updateOrganization'])->name('profile.update.organization');
    Route::patch('/profile/organization/additional', [ProfileController::class, 'updateOrganizationAdditional'])->name('profile.update.organization.additional');

    // Activities
    Route::get('/activities-feed', [ActivityController::class, 'feed'])->name('activities.feed');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities-list', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
        // org->activities
    Route::patch('/activities/{activity}/update-status', [ActivityController::class, 'updateStatus'])->name('activities.updateStatus');
    Route::get('/activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
    Route::patch('/activities/{activity}/complete', [ActivityController::class, 'completeStore'])->name('activities.complete.store');

    Route::get('/activities/{activity}/signups', [ActivityController::class, 'showSignups'])->name('activities.show_signups');
    Route::patch('/activities/{activity}/volunteers/{volunteer}', [ActivityController::class, 'updateVolunteerStatus'])->name('activities.update_volunteer_status');
    Route::patch('/activities/{activity}/update-multiple-volunteer-status', [ActivityController::class, 'updateMultipleVolunteerStatus'])->name('activities.update_multiple_volunteer_status');
        // volunteer->activities
    Route::post('/activities/{activity}/register', [ActivityController::class, 'register'])->name('activities.register')->middleware('auth');

});

// Public profile route (accessible without authentication)
Route::get('/profile/{url}', [PublicProfileController::class, 'show'])->name('profile.public');

Route::middleware(['web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');
});

// Route::get('/home', function () {
//     return view('home');
// })->middleware(['auth'])->name('home');

//Email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/login', [CustomLoginController::class, 'login'])->name('login');

require __DIR__.'/auth.php';

Route::patch('/profile/volunteer/additional', [ProfileController::class, 'updateVolunteerAdditional'])
    ->name('profile.update.volunteer.additional');
