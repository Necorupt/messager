<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/chat', ChatController::class);
    Route::post('/chat/{chat_id}/add-member', [ChatController::class,'addMember']);
    Route::get('/chat/{chat_id}/members', [ChatController::class,'members']);
    Route::get('/chat/{chat_id}/messages', [ChatController::class,'getMessages']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/message', ChatMessageController::class);
});