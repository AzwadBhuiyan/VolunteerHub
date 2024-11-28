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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityMilestoneController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActivityRequestController;
use App\Http\Controllers\TutorialProgressController;

Route::get('/connection', function () {
    try {
        DB::connection()->getPdo();
        return 'connected successfully';
    } catch (\Exception $ex) {
        dd($ex->getMessage());
    }
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/load-more-activities', [HomeController::class, 'loadMore'])->name('activities.load-more');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');

// Route::get('/', function () {
//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });


// Two factor auth
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa/verify', [TwoFactorController::class, 'show'])
        ->name('2fa.verify');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);
    Route::post('/2fa/resend', [TwoFactorController::class, 'resend'])
        ->name('2fa.resend');
});


// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
                
        // Activity routes
        Route::get('/activities', [AdminController::class, 'activities'])->name('activities.index');
        Route::delete('/activities/{activity}', [AdminController::class, 'deleteActivity'])->name('activities.delete');
        Route::post('/admin/activities/close-expired', [AdminController::class, 'closeExpiredActivities'])->name('activities.close-expired');
        
        // Idea Thread routes
        Route::get('/idea-threads', [AdminController::class, 'ideaThreads'])->name('idea-threads.index');
        Route::delete('/idea-threads/{ideaThread}', [AdminController::class, 'deleteIdeaThread'])->name('idea-threads.delete');

        // Volunteer Management
        Route::get('/volunteers', [AdminController::class, 'volunteers'])->name('volunteers.index');
        Route::get('/volunteers/{volunteer}/edit', [AdminController::class, 'editVolunteer'])->name('volunteers.edit');
        Route::patch('/volunteers/{volunteer}', [AdminController::class, 'updateVolunteer'])->name('volunteers.update');
        
        // Organization Management
        Route::get('/organizations', [AdminController::class, 'organizations'])->name('organizations.index');
        Route::get('/organizations/{organization}/edit', [AdminController::class, 'editOrganization'])->name('organizations.edit');
        Route::patch('/organizations/{organization}', [AdminController::class, 'updateOrganization'])->name('organizations.update');
        Route::patch('/organizations/{organization}/toggle-verification', [AdminController::class, 'toggleOrganizationVerification'])
            ->name('organizations.toggle-verification');
    });
});




// Public profile route (accessible without authentication)
Route::get('/profile/{url}', [PublicProfileController::class, 'show'])->name('profile.public');

// Search routes
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/search/suggestions', [App\Http\Controllers\SearchController::class, 'suggestions'])
    ->name('search.suggestions');



//main routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/edit-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/edit-profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/security', [ProfileController::class, 'updateSecurity'])->name('profile.update.security');
    
    
    // update organization information -- partials are independent
    Route::patch('/profile/organization', [ProfileController::class, 'updateOrganization'])->name('profile.update.organization');
    Route::patch('/profile/organization/additional', [ProfileController::class, 'updateOrganizationAdditional'])->name('profile.update.organization.additional');

    // Activities
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities-list', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/feed', [ActivityController::class, 'feed'])->name('activities.feed');
    // TURNED PUBLIC // Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    // Route::get('/activities/{activity}/accomplished', [ActivityController::class, 'showAccomplished'])->name('activities.show_accomplished');
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
        // timeline & milestone
    Route::get('/activities/{activity}/timeline', [ActivityController::class, 'timeline'])->name('activities.timeline');
    Route::post('/activities/{activity}/milestones', [ActivityMilestoneController::class, 'store'])->name('activities.milestones.store');
    Route::post('/milestones/{milestone}/read', [ActivityMilestoneController::class, 'markAsRead'])->name('milestones.mark-as-read');


    // Idea Board
    Route::get('/idea-board', [IdeaThreadController::class, 'index'])->name('idea_board.index');
    Route::get('/idea-board/create', [IdeaThreadController::class, 'create'])->name('idea_board.create');
    Route::get('/idea-board/my-ideas', [IdeaThreadController::class, 'myIdeas'])->name('idea_board.my-ideas');
    Route::post('/idea-board', [IdeaThreadController::class, 'store'])->name('idea_board.store');
    Route::get('/idea-board/{ideaThread}', [IdeaThreadController::class, 'show'])->name('idea_board.show');
    Route::post('/idea-board/{ideaThread}/comment', [IdeaThreadController::class, 'comment'])->name('idea_board.comment');
    // Route::post('/idea-board/{ideaThread}/vote', [IdeaThreadController::class, 'vote'])->name('idea_board.vote');
    Route::post('/idea-board/polls/{poll}/vote', [IdeaThreadController::class, 'pollVote'])->name('idea_board.poll_vote');
    Route::post('/idea-board/vote', [IdeaThreadController::class, 'vote'])->name('idea_board.vote');
    Route::get('/idea-board/{thread}/comments', [IdeaThreadController::class, 'loadMoreComments'])->name('idea_board.load_more_comments');
    Route::post('/idea-board/{ideaThread}/close', [IdeaThreadController::class, 'close'])->name('idea_board.close');
    


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

    //Activity Request
    Route::get('/activity-requests', [ActivityRequestController::class, 'index'])->name('activity-requests.index');
    Route::get('/activity-requests/create', [ActivityRequestController::class, 'create'])->name('activity-requests.create');
    Route::post('/activity-requests', [ActivityRequestController::class, 'store'])->name('activity-requests.store');
    Route::post('/activity-requests/{request}/approve', [ActivityRequestController::class, 'approve'])->name('activity-requests.approve');
    Route::post('/activity-requests/{request}/reject', [ActivityRequestController::class, 'reject'])->name('activity-requests.reject');
    Route::get('/activity-requests/{request}', [ActivityRequestController::class, 'show'])->name('activity-requests.show');

});

// tutorial progress
// Route::get('/api/tutorial-progress/{path}', [TutorialProgressController::class, 'check'])
//     ->middleware(['auth'])
//     ->where('path', '.*');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Public activities feed
Route::get('/activities-feed', [ActivityController::class, 'feed'])->name('activities.feed');

// Individual Activity public view (ongoing & completed)
Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('/activities/{activity}/accomplished', [ActivityController::class, 'showAccomplished'])->name('activities.show_accomplished');


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
    ->middleware(['auth', 'throttle:6,1', 'verify.rate.limit'])
    ->name('verification.send');

Route::post('/login', [CustomLoginController::class, 'login'])->name('login');

require __DIR__.'/auth.php';

Route::patch('/profile/volunteer/additional', [ProfileController::class, 'updateVolunteerAdditional'])
    ->name('profile.update.volunteer.additional');

