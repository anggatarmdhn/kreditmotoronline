<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified using OTP.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        $sessionKey = 'email_verification_otp_' . $request->user()->id;
        $sessionExpiresKey = 'email_verification_otp_expires_at_' . $request->user()->id;

        if (!session()->has($sessionKey) || now()->gt(session($sessionExpiresKey))) {
            throw ValidationException::withMessages([
                'otp_code' => ['Kode OTP sudah kedaluwarsa atau belum dikirim. Silakan request ulang.'],
            ]);
        }

        if ($request->otp_code != session($sessionKey)) {
            throw ValidationException::withMessages([
                'otp_code' => ['Kode OTP tidak valid.'],
            ]);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        session()->forget([$sessionKey, $sessionExpiresKey]);

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
