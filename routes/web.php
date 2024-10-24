<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\IdeaThreadController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;

Route::get('/connection', function () {
    try {
        DB::connection()->getPdo();
        return 'connected successfully';
    } catch (\Exception $ex) {
        dd($ex->getMessage());
    }
});


// Route::get('/', function () {
//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/edit-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/edit-profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    // update organization information -- partials are independent
    Route::patch('/profile/organization', [ProfileController::class, 'updateOrganization'])->name('profile.update.organization');
    Route::patch('/profile/organization/additional', [ProfileController::class, 'updateOrganizationAdditional'])->name('profile.update.organization.additional');

    // Activities
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities-list', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::get('/activities/{activity}/accomplished', [ActivityController::class, 'showAccomplished'])->name('activities.show_accomplished');
        // org->activities
    Route::patch('/activities/{activity}/update-status', [ActivityController::class, 'updateStatus'])->name('activities.updateStatus');
    Route::get('/activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
    Route::patch('/activities/{activity}/complete', [ActivityController::class, 'completeStore'])->name('activities.complete.store');

    Route::get('/activities/{activity}/signups', [ActivityController::class, 'showSignups'])->name('activities.show_signups');
    Route::patch('/activities/{activity}/volunteers/{volunteer}', [ActivityController::class, 'updateVolunteerStatus'])->name('activities.update_volunteer_status');
    Route::patch('/activities/{activity}/update-multiple-volunteer-status', [ActivityController::class, 'updateMultipleVolunteerStatus'])->name('activities.update_multiple_volunteer_status');
        // volunteer->activities
    Route::post('/activities/{activity}/register', [ActivityController::class, 'register'])->name('activities.register')->middleware('auth');
    Route::delete('/activities/{activity}/cancel-registration', [ActivityController::class, 'cancelRegistration'])->name('activities.cancel_registration');


    // Idea Board
    Route::get('/idea-board', [IdeaThreadController::class, 'index'])->name('idea_board.index');
    Route::get('/idea-board/create', [IdeaThreadController::class, 'create'])->name('idea_board.create');
    Route::post('/idea-board', [IdeaThreadController::class, 'store'])->name('idea_board.store');
    Route::get('/idea-board/{ideaThread}', [IdeaThreadController::class, 'show'])->name('idea_board.show');
    Route::post('/idea-board/{ideaThread}/comment', [IdeaThreadController::class, 'comment'])->name('idea_board.comment');
    // Route::post('/idea-board/{ideaThread}/vote', [IdeaThreadController::class, 'vote'])->name('idea_board.vote');
    Route::post('/idea-board/poll-vote/{pollOption}', [IdeaThreadController::class, 'pollVote'])->name('idea_board.poll_vote');
    Route::post('/idea-board/vote', [IdeaThreadController::class, 'vote'])->name('idea_board.vote');

    Route::get('/idea-board/{thread}/comments', [IdeaThreadController::class, 'loadMoreComments'])->name('idea_board.load_more_comments');


    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'showFavorites'])->name('favorites.show');
    Route::get('/favorites/edit', [FavoriteController::class, 'edit'])->name('favorites.edit');
    Route::patch('/favorites', [FavoriteController::class, 'update'])->name('favorites.update');

    //Follow
    Route::get('/following/manage', [FollowController::class, 'manageFollowing'])->name('following.manage');
    Route::get('/following', [FollowController::class, 'index'])->name('following.index');

    Route::post('/organizations/{organization}/follow', [FollowController::class, 'follow'])->name('organizations.follow');
    Route::delete('/organizations/{organization}/unfollow', [FollowController::class, 'unfollow'])->name('organizations.unfollow');

    
    Route::post('/volunteers/{volunteer}/follow', [FollowController::class, 'followVolunteer'])->name('volunteers.follow');
    Route::delete('/volunteers/{volunteer}/unfollow', [FollowController::class, 'unfollowVolunteer'])->name('volunteers.unfollow');
    Route::patch('/volunteers/{volunteer}/toggle-follow', [FollowController::class, 'toggleFollow'])->name('volunteers.toggle-follow');

});

// Public activities feed
Route::get('/activities-feed', [ActivityController::class, 'feed'])->name('activities.feed');

// Public profile route (accessible without authentication)
Route::get('/profile/{url}', [PublicProfileController::class, 'show'])->name('profile.public');

Route::middleware(['web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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

