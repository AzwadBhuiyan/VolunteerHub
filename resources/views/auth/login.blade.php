<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <!-- check if email verified -->
    @if ($errors->has('email'))
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ $errors->first('email') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <h3 class="mt-6 text-center text-2xl font-extrabold">
                {{ __('Log in to your accounts') }}
            </h3>
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Login Button -->
        <div class="mt-4">
            <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                {{ __('Log in') }}
            </button>
        </div>

        <!-- Forgot Password and Sign Up links -->
        <div class="   mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
<br>
            <hr class="my-6 border-gray-300 w-full mt-4 mb-4">

            @if (Route::has('register'))
                <div class="text-sm text-center">
                    <span class="text-gray-600">{{ __("Don't have an account?") }}</span>
                    <a href="{{ route('register') }}" class="font-bold text-green-600 hover:text-green-500">
                        {{ __("Sign up") }}
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
