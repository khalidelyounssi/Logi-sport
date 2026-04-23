<section>
    <header>
        <h2 class="text-lg font-black text-white">Profile Information</h2>
        <p class="mt-1 text-sm text-slate-400">Update your name and email address.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="ui-label">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="ui-input">
            @error('name')
                <p class="ui-field-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="ui-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="ui-input">
            @error('email')
                <p class="ui-field-error">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-2xl border border-amber-400/30 bg-amber-500/10 p-3 text-sm text-amber-300">
                    <p>Your email address is unverified.</p>
                    <button form="send-verification" class="mt-1 font-semibold underline decoration-emerald-400/60 underline-offset-4">
                        Click here to re-send verification email.
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <x-ui.alert class="mt-3">
                        A new verification link has been sent to your email address.
                    </x-ui.alert>
                @endif
            @endif
        </div>

        <div class="flex items-center gap-3">
            <x-ui.button type="submit">Save Changes</x-ui.button>

            @if (session('status') === 'profile-updated')
                <span class="text-sm font-semibold text-emerald-300">Saved.</span>
            @endif
        </div>
    </form>
</section>
