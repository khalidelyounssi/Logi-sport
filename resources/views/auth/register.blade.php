<x-guest-layout>
    <x-ui.card padding="p-8 sm:p-10">
        <div class="mb-8 text-center">
            <p class="ls-kicker">Create Profile</p>
            <h1 class="mt-4 text-3xl font-black text-white">Create Account</h1>
            <p class="mt-3 text-sm leading-7 text-slate-400">Join the platform as organizer, player, or referee and unlock the full competition workspace.</p>
        </div>

        @if($errors->any())
            <x-ui.alert variant="error" class="mb-5">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="ui-label">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="ui-input">
            </div>

            <div>
                <label for="email" class="ui-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="ui-input">
            </div>

            <div>
                <label for="role" class="ui-label">Role</label>
                <select id="role" name="role" class="ui-select" required>
                    <option value="player" @selected(old('role') === 'player')>Player</option>
                    <option value="organizer" @selected(old('role') === 'organizer')>Organizer</option>
                    <option value="referee" @selected(old('role') === 'referee')>Referee</option>
                </select>
            </div>

            <div>
                <label for="password" class="ui-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="ui-input">
            </div>

            <div>
                <label for="password_confirmation" class="ui-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="ui-input">
            </div>

            <x-ui.button type="submit" variant="primary" size="lg" class="w-full">
                Create Account
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="ls-inline-link">Sign in</a>
        </p>
    </x-ui.card>
</x-guest-layout>
