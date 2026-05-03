<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification OTP.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        $sessionKey = 'email_verification_otp_' . $request->user()->id;
        $sessionExpiresKey = 'email_verification_otp_expires_at_' . $request->user()->id;

        session([
            $sessionKey => $otp,
            $sessionExpiresKey => now()->addMinutes(15)
        ]);

        try {
            Mail::raw("Kode OTP Anda untuk verifikasi email adalah: {$otp}. Kode ini berlaku selama 15 menit.", function ($message) use ($request) {
                $message->to($request->user()->email)
                        ->subject('Kode OTP Verifikasi Email');
            });
        } catch (\Exception $e) {
            // Ignore email error in dev or if mail not configured properly
        }

        return back()->with('status', 'verification-otp-sent');
    }
}
