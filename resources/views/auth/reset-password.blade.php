<x-guest-layout>
    <x-ui.card padding="p-8 sm:p-10">
        <div class="mb-8 text-center">
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Account Recovery</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Set New Password</h1>
            <p class="mt-2 text-sm text-slate-500">Choose a strong password to secure your account.</p>
        </div>

        @if ($errors->any())
            <x-ui.alert variant="error" class="mb-5">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="ui-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="ui-input">
            </div>

            <div>
                <label for="password" class="ui-label">New Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="ui-input">
            </div>

            <div>
                <label for="password_confirmation" class="ui-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="ui-input">
            </div>

            <x-ui.button type="submit" class="w-full" size="lg">
                Reset Password
            </x-ui.button>
        </form>
    </x-ui.card>
</x-guest-layout>
