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
    'lessons' => LessonController::class,
    'cards' => CardController::class,
]);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{id}/assignments', [UserController::class, 'getAssignments']);
});

Route::apiResource('communication-methods', CommunicationMethodController::class);