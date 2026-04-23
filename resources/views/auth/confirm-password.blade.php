<x-guest-layout>
    <x-ui.card padding="p-8 sm:p-10">
        <div class="mb-8 text-center">
            <p class="ls-kicker">Security Check</p>
            <h1 class="mt-4 text-3xl font-black text-white">Confirm Password</h1>
            <p class="mt-3 text-sm leading-7 text-slate-400">Re-enter your password to continue this protected action.</p>
        </div>

        @if ($errors->any())
            <x-ui.alert variant="error" class="mb-5">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <label for="password" class="ui-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="ui-input">
            </div>

            <x-ui.button type="submit" class="w-full" size="lg">
                Confirm Password
            </x-ui.button>
        </form>
    </x-ui.card>
</x-guest-layout>
