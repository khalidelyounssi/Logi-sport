<x-guest-layout>
    <x-ui.card padding="p-8 sm:p-10">
        <div class="mb-8 text-center">
            <p class="ls-kicker">Organizer Access</p>
            <h1 class="mt-4 text-3xl font-black text-white">Welcome Back</h1>
            <p class="mt-3 text-sm leading-7 text-slate-400">Sign in to access your command center, manage tournaments, and monitor match activity live.</p>
        </div>

        @if(session('status'))
            <x-ui.alert variant="success" class="mb-5">
                {{ session('status') }}
            </x-ui.alert>
        @endif

        @if($errors->any())
            <x-ui.alert variant="error" class="mb-5">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="ui-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="ui-input">
            </div>

            <div>
                <label for="password" class="ui-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="ui-input">
            </div>

            <div class="flex items-center justify-between gap-3">
                <label class="inline-flex items-center gap-2 text-sm text-slate-400">
                    <input type="checkbox" name="remember" class="rounded border-slate-600 bg-slate-900 text-emerald-400 focus:ring-emerald-400">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="ls-inline-link text-sm">
                        Forgot password?
                    </a>
                @endif
            </div>

            <x-ui.button type="submit" variant="primary" size="lg" class="w-full">
                Sign In
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            New to Logi-Sport?
            <a href="{{ route('register') }}" class="ls-inline-link">Create account</a>
        </p>
    </x-ui.card>
</x-guest-layout>
