<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CommunicationMethodController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
});

Route::apiResources([
    'cards' => CardController::class,
]);


Route::middleware('auth:api')->group(function () {
    Route::get('/users/{id}/assignments', [UserController::class, 'getAssignments']);
    Route::get('/cards/preferred', [CardController::class, 'preferred']);
    Route::post('/card/{id}/response', [CardController::class, 'storeResponse']);
});

Route::apiResource('communication-methods', CommunicationMethodController::class);

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('/admin/lessons', [LessonController::class, 'store']);
    Route::get('/lessons', [LessonController::class, 'index']);
    Route::get('/lessons/{id}', [LessonController::class, 'show']);
});
Route::get('/cards/{card}/present/{method}', [App\Http\Controllers\CardController::class, 'present']);
