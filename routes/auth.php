<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'createEmailForm'])
        ->name('register');

    Route::post('register/send-otp', [RegisteredUserController::class, 'sendOtp'])
        ->name('register.send-otp');

    Route::get('register/verify-otp', [RegisteredUserController::class, 'verifyOtpForm'])
        ->name('register.verify-otp');

    Route::post('register/verify-otp', [RegisteredUserController::class, 'verifyOtp'])
        ->name('register.verify-otp.submit');

    Route::get('register/complete', [RegisteredUserController::class, 'create'])
        ->name('register.complete');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'requestForm'])
        ->name('password.request');

    Route::post('forgot-password', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'sendOtp'])
        ->name('password.email');

    Route::get('reset-password/otp', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'verifyForm'])
        ->name('password.otp.verify');

    Route::post('reset-password/otp', [\App\Http\Controllers\Auth\OtpPasswordResetController::class, 'resetPassword'])
        ->name('password.otp.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::post('verify-email', [\App\Http\Controllers\Auth\VerifyEmailController::class, 'verifyOtp'])
        ->middleware(['throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
