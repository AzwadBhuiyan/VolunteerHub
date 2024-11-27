<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorialProgressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/tutorial-progress', [TutorialProgressController::class, 'update']);
    Route::get('/tutorial-progress/{path?}', [TutorialProgressController::class, 'check'])
        ->where('path', '.*');
    // Route::post('/tutorial-progress', [TutorialProgressController::class, 'save']);
});