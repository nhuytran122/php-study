<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryConfigController;
use App\Http\Controllers\SalaryController;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware(['auth:api']);
Route::post('/refresh', [AuthController::class, 'refresh'])
    ->middleware(['auth:api']);
Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware(['auth:api']);
Route::post('/change-password', [AuthController::class, 'changePassword'])
    ->middleware(['auth:api']);

Route::resource('positions', PositionController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('leave-types', LeaveTypeController::class);
Route::resource('leave-requests', LeaveRequestController::class);

Route::group(['middleware' => ['role:finance|admin']], function () {
    Route::resource('salaries', SalaryController::class);
    Route::resource('salary-configs', SalaryConfigController::class);
});

Route::group(['middleware' => ['role:hr|manager|admin']], function () {
    Route::post('/leave-requests/{id}/approval', [LeaveRequestController::class, 'approveOrReject']);
    Route::post('/leave-requests/mark-absence', [LeaveRequestController::class, 'markAbsence']);
});

Route::group(['middleware' => ['role:hr|admin']], function () {
    Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::post('/attendances', [AttendanceController::class, 'create']);
});

Route::get("/test-email", function(){
    $name = 'Nhu Y';
    Mail::to('nhuyvinmini1218@gmail.com')->send(new MyEmail($name));
});