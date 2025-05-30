<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-[#4b6f6b] font-semibold" />
            <x-text-input id="name"
                class="block mt-1 w-full border border-[#4b6f6b] focus:border-[#4b6f6b] focus:ring focus:ring-[#4b6f6b]/50 rounded"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-[#4b6f6b] font-semibold" />
            <x-text-input id="email"
                class="block mt-1 w-full border border-[#4b6f6b] focus:border-[#4b6f6b] focus:ring focus:ring-[#4b6f6b]/50 rounded"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-[#4b6f6b] font-semibold" />
            <x-text-input id="password"
                class="block mt-1 w-full border border-[#4b6f6b] focus:border-[#4b6f6b] focus:ring focus:ring-[#4b6f6b]/50 rounded"
                type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                class="text-[#4b6f6b] font-semibold" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full border border-[#4b6f6b] focus:border-[#4b6f6b] focus:ring focus:ring-[#4b6f6b]/50 rounded"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

    <!-- Hidden Role Input -->
    <input type="hidden" name="role_id" value="2" />

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}"
                class="underline text-sm text-[#4b6f6b] hover:text-[#376057] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4b6f6b]">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-[#4b6f6b] hover:bg-[#376057] focus:ring-[#4b6f6b]">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>