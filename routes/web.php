<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityPolicyController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('landing'))->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/login/2fa', [AuthController::class, 'showTwoFactorChallenge'])->name('auth.2fa.challenge');
    Route::post('/login/2fa', [AuthController::class, 'verifyTwoFactorChallenge'])->name('auth.2fa.verify');
    Route::post('/login/2fa/resend', [AuthController::class, 'resendTwoFactorCode'])->name('auth.2fa.resend');
});

Route::middleware(['auth', 'password.changed'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');

    Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave.index');
    Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave.store');

    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/security/2fa', [ProfileController::class, 'updateTwoFactor'])->name('profile.security.2fa');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/security/change-password', [AuthController::class, 'showChangePassword'])->name('security.change-password');
    Route::post('/security/change-password', [AuthController::class, 'changePassword'])->name('security.update-password');
});

Route::middleware(['auth', 'can:manage-security'])->group(function () {
    Route::get('/admin/security/policies', [SecurityPolicyController::class, 'index'])->name('security.policies.index');
    Route::put('/admin/security/policies', [SecurityPolicyController::class, 'update'])->name('security.policies.update');
    Route::get('/admin/security/dashboard', [SecurityPolicyController::class, 'dashboard'])->name('security.dashboard');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
});
