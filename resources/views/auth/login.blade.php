<x-guest-layout>
    <a href="/" class="flex justify-center items-center font-bold text-2xl">
        Siamawolu Admin
    </a>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4 mt-4" :errors="$errors" />

    <form method="POST" action="{{ route('login') }}" class="mt-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-label for="username" :value="__('Username')" />
            <x-input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus />
        </div>

        <!-- Password -->
        <div class="mt-3">
            <x-label for="password" :value="__('Password')" />
            <x-input type="password" name="password" id="password" required autocomplete="current-password" />
        </div>

        <div class="flex justify-between mt-4">
            <div>
                @if (Route::has('password.request'))
                <a class="block text-sm fontme text-indigo-700 hover:underline" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <x-button class="w-full">
                {{ __('Log in') }}
            </x-button>
        </div>

    </form>
</x-guest-layout>
