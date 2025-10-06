<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ $value }}
        </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="login" value="{{ __('Email / Username') }}" />
                <x-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            {{-- Actions row: Forgot | Create | Log in --}}
            <div class="mt-6 flex items-center justify-between gap-4 flex-wrap">
                <div class="links flex items-center gap-4">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="underline text-indigo-600 hover:text-indigo-700">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif

                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
                    <a href="{{ route('register') }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                        {{ __('Create an account') }}
                    </a>
                    @endif
                </div>

                <x-button>
                    {{ __('Log in') }}
                </x-button>
            </div>


        </form>
    </x-authentication-card>
</x-guest-layout>