<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi email Anda dengan memasukkan kode OTP yang telah kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami akan mengirimkan yang baru.') }}
    </div>

    @if (session('status') == 'verification-otp-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Kode OTP verifikasi baru telah dikirimkan ke email Anda.') }}
        </div>
    @endif

    <div class="mt-4">
        <form method="POST" action="{{ route('verification.verify') }}">
            @csrf

            <!-- OTP Code -->
            <div>
                <x-input-label for="otp_code" :value="__('Kode OTP')" />
                <x-text-input id="otp_code" class="block mt-1 w-full" type="text" name="otp_code" required autofocus />
                <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Verifikasi OTP') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Kirim Ulang OTP') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
