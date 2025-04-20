<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware(['auth:api']);
Route::post('/refresh', [AuthController::class, 'refresh'])
    ->middleware(['auth:api']);
Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware(['auth:api']);


// Route::group(['middleware' => ['role:admin|manager|employee']], function () {
    Route::middleware(['isAdmin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});