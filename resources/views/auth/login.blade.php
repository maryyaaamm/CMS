<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-pink-600 shadow-sm focus:ring-pink-500 dark:focus:ring-pink-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3 bg-pink-600 hover:bg-pink-500 focus:bg-pink-700">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to right, #fdfbfb, #ebedee);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .auth-links {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            align-items: center;
        }

        .auth-link {
            display: inline-block;
            padding: 5px 10px;
            color: #fff;
            background-color: #e91e63;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .auth-link.ml-4 {
            margin-left: 10px;
        }

        .auth-link:hover {
            background-color: #c2185b;
        }

        .block {
            display: block;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .ml-2 {
            margin-left: 0.5rem;
        }

        .ml-3 {
            margin-left: 0.75rem;
        }

        .w-full {
            width: 100%;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-gray-600 {
            color: #4B5563;
        }

        .text-gray-700 {
            color: #374151;
        }

        .text-gray-400 {
            color: #9CA3AF;
        }

        .dark\:text-gray-400 {
            color: #9CA3AF;
        }

        .dark\:bg-gray-900 {
            background-color: #1F2937;
        }

        .dark\:border-gray-700 {
            border-color: #374151;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .focus\:ring-pink-500 {
            border-color: #EC4899;
        }

        .dark\:focus\:ring-pink-600 {
            border-color: #D946EF;
        }

        .dark\:focus\:ring-offset-gray-800 {
            border-color: #1F2937;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .focus\:outline-none {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .focus\:ring-2 {
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
        }

        .focus\:ring-offset-2 {
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
        }

        .bg-pink-600 {
            background-color: #E91E63;
        }

        .hover\:bg-pink-500 {
            background-color: #D81B60;
        }

        .focus\:bg-pink-700 {
            background-color: #C2185B;
        }

        .underline {
            text-decoration: underline;
        }

        .hover\:text-gray-900 {
            color: #1F2937;
        }

        .dark\:hover\:text-gray-100 {
            color: #F9FAFB;
        }

    </style>
</x-guest-layout>
