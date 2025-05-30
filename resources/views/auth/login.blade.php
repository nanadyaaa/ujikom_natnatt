<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#4b6f6b] font-semibold" />
            <x-text-input id="email"
                class="block mt-1 w-full border border-[#4b6f6b] focus:border-[#4b6f6b] focus:ring focus:ring-[#4b6f6b]/50 rounded"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-[#4b6f6b] font-semibold" />

            <x-text-input id="password"
                class="block mt-1 w-full border border-[#4b6f6b] focus:border-[#4b6f6b] focus:ring focus:ring-[#4b6f6b]/50 rounded"
                type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center text-[#4b6f6b]">
                <input id="remember_me" type="checkbox"
                    class="rounded border-[#4b6f6b] text-[#4b6f6b] shadow-sm focus:ring-[#4b6f6b]" name="remember">
                <span class="ms-2 text-sm text-[#4b6f6b]">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-[#4b6f6b] hover:text-[#376057] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4b6f6b]"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-[#4b6f6b] hover:bg-[#376057] focus:ring-[#4b6f6b]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>