<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\InmateController;
use App\Http\Controllers\AttendanceControler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// routes/web.php
Route::get('/', [AttendanceControler::class, 'scan']);


Route::post('/auth/save',[AccountController::class, 'save'])->name('auth.save');
Route::post('/auth/check',[AccountController::class, 'check'])->name('auth.check');
Route::get('/auth/logout',[AccountController::class, 'logout'])->name('auth.logout');

Route::get('/Scan-QR', [AttendanceControler::class, 'scan']);
Route::post('/qr-code-scans', [AttendanceControler::class, 'store'])->name('qr-code-scans.store');

Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('/admin/home',[AccountController::class, 'dashboard']);
    Route::get('/admin/login',[AccountController::class, 'login'])->name('auth.login');
    Route::get('/admin/register',[AccountController::class, 'register'])->name('auth.register');

    Route::get('/visitor-registration', [QRCodeController::class, 'showForm']);
    Route::post('/Save-visitor', [QRCodeController::class, 'save_visitor']);
    Route::get('/visitor-info', [QRCodeController::class, 'View_visitors']);
    Route::get('/generate-qr-code/{id}', [QRCodeController::class, 'generateQRCode']);
    Route::post('/Delete-visitor', [QRCodeController::class, 'delete_visitor']);
    Route::get('/Update-visitor/{id}', [QRCodeController::class, 'update_visitor']);
    Route::post('/Save-visitor-update/{id}', [QRCodeController::class, 'save_update_visitor']);

    Route::get('/inmate-registration', [InmateController::class, 'showForm']);
    Route::post('/Save-inmate', [InmateController::class, 'save_inmate']);
    Route::get('/inmate-info', [InmateController::class, 'View_inmate']);
    Route::post('/Delete-inmate', [InmateController::class, 'delete_inmate']);
    Route::get('/Update-inmate/{id}', [InmateController::class, 'update_inmate']);
    Route::post('/Save-inmate-update/{id}', [InmateController::class, 'save_inmate_update']);

    Route::get('/Attendance-info', [AttendanceControler::class, 'View_Attendance']);
    Route::post('/Delete-Attendance', [AttendanceControler::class, 'delete_attendance']);
    
    // routes/web.php

    Route::post('/generate-attendance-pdf', [AttendanceControler::class, 'generateAttendancePDF'])->name('generate-attendance-pdf');





});


