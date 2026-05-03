<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function createEmailForm(): View
    {
        return view('auth.register-email');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        session([
            'register_email' => $request->email,
            'register_otp' => $otp,
            'register_otp_expires_at' => now()->addMinutes(15)
        ]);

        try {
            Mail::raw("Kode OTP Anda untuk registrasi akun adalah: {$otp}. Kode ini berlaku selama 15 menit.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Kode OTP Registrasi');
            });
        } catch (\Exception $e) {
            // Ignore email error in dev or if mail not configured properly
        }

        return redirect()->route('register.verify-otp')
            ->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function verifyOtpForm(Request $request): View|RedirectResponse
    {
        if (!session()->has('register_email')) {
            return redirect()->route('register');
        }

        return view('auth.register-verify-otp');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        if (!session()->has('register_otp') || now()->gt(session('register_otp_expires_at'))) {
            throw ValidationException::withMessages([
                'otp_code' => ['Kode OTP sudah kedaluwarsa. Silakan request ulang.'],
            ]);
        }

        if ($request->otp_code != session('register_otp')) {
            throw ValidationException::withMessages([
                'otp_code' => ['Kode OTP tidak valid.'],
            ]);
        }

        session(['register_otp_verified' => true]);

        return redirect()->route('register.complete');
    }

    /**
     * Display the registration view.
     */
    public function create(): View|RedirectResponse
    {
        if (!session()->has('register_email') || !session('register_otp_verified')) {
            return redirect()->route('register');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if (!session()->has('register_email') || !session('register_otp_verified')) {
            return redirect()->route('register');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = session('register_email');

        // Check again to be absolutely sure
        if (User::where('email', $email)->exists()) {
             return redirect()->route('register')->withErrors(['email' => 'Email is already registered.']);
        }

        $user = User::create([
            'role_id' => Role::query()->where('slug', 'klien')->value('id'),
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Mark as verified!
        ]);

        // Clean up session
        session()->forget(['register_email', 'register_otp', 'register_otp_expires_at', 'register_otp_verified']);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('landing', absolute: false));
    }
}
