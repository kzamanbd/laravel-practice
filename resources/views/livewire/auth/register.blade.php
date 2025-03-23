<div>
    <div class="flex w-full flex-col text-center">
        <div class="font-medium text-zinc-800 dark:text-white text-2xl mb-2 mt-2">
            Create an account
        </div>
        <div class="text-sm text-zinc-500 dark:text-white/70 mb-4">
            Enter your details below to create your account
        </div>
    </div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="mb-3 flex justify-center w-full">
            {{ __('Register') }}
        </x-primary-button>

        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            Already have an account?
            <a class="inline font-medium underline-offset-[6px] hover:decoration-current underline text-gray-600 decoration-[color-mix(in_oklab,var(--color-accent-content),transparent_80%)]"
                href="{{ route('login') }}" wire:navigate>
                Login
            </a>
        </div>
    </form>
</div>
