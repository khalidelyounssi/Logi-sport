<x-guest-layout>
    <x-ui.card padding="p-8 sm:p-10">
        <div class="mb-8 text-center">
            <p class="ls-kicker">Account Recovery</p>
            <h1 class="mt-4 text-3xl font-black text-white">Reset Password</h1>
            <p class="mt-3 text-sm leading-7 text-slate-400">Enter your email and we will send you a reset link.</p>
        </div>

        @if (session('status'))
            <x-ui.alert class="mb-5">
                {{ session('status') }}
            </x-ui.alert>
        @endif

        @if ($errors->any())
            <x-ui.alert variant="error" class="mb-5">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="ui-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="ui-input">
            </div>

            <x-ui.button type="submit" class="w-full" size="lg">
                Send Reset Link
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            <a href="{{ route('login') }}" class="ls-inline-link">Back to login</a>
        </p>
    </x-ui.card>
</x-guest-layout>
