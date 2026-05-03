<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Silakan masukkan 6 digit kode OTP yang telah dikirimkan ke email ') }} <span class="font-bold">{{ session('register_email') }}</span>.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register.verify-otp.submit') }}">
        @csrf

        <!-- OTP Code -->
        <div>
            <x-input-label for="otp_code" :value="__('Kode OTP')" />
            <x-text-input id="otp_code" class="block mt-1 w-full" type="text" name="otp_code" required autofocus pattern="[0-9]{6}" title="Masukkan 6 digit angka OTP" maxlength="6" />
            <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verifikasi OTP') }}
            </x-primary-button>
        </div>
    </form>
    
    <div class="mt-4 text-center">
        <form method="POST" action="{{ route('register.send-otp') }}" class="inline">
            @csrf
            <input type="hidden" name="email" value="{{ session('register_email') }}">
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Belum menerima OTP? Kirim Ulang') }}
            </button>
        </form>
    </div>
</x-guest-layout>
