<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class OtpPasswordResetController extends Controller
{
    public function requestForm()
    {
        return view('auth.forgot-password-otp');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        
        // Generate 6 digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);

        // Send Email
        try {
            Mail::raw("Kode OTP Anda untuk reset password adalah: {$otp}. Kode ini berlaku selama 15 menit.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Reset Password');
            });
        } catch (\Exception $e) {
            // Ignore error
        }

        return redirect()->route('password.otp.verify', ['email' => $user->email])
            ->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function verifyForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-otp', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp_code', $request->otp_code)
                    ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'otp_code' => ['Kode OTP tidak valid.'],
            ]);
        }

        if (now()->gt($user->otp_expires_at)) {
            throw ValidationException::withMessages([
                'otp_code' => ['Kode OTP sudah kedaluwarsa. Silakan request ulang.'],
            ]);
        }

        // Reset password
        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
    }
}
