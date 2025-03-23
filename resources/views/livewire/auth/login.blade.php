<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex w-full flex-col text-center">
        <div class="font-medium text-zinc-800 dark:text-white text-2xl mb-2 mt-2">
            Log in to your account
        </div>
        <div class="text-sm text-zinc-500 dark:text-white/70 mb-4">
            Enter your email and password below to log in
        </div>
    </div>

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="my-4 flex justify-between">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="remember" id="remember" type="checkbox"
                    class="rounded-sm dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-xs focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <x-primary-button class="mb-3 flex justify-center w-full">
            {{ __('Log in') }}
        </x-primary-button>
        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            Don't have an account?
            <a class="inline font-medium underline-offset-[6px] hover:decoration-current underline text-gray-600 decoration-[color-mix(in_oklab,var(--color-accent-content),transparent_80%)]"
                href="{{ route('register') }}" wire:navigate>
                Sign up
            </a>
        </div>
    </form>
</div>
