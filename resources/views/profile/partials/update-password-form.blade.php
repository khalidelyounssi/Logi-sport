<section>
    <header>
        <h2 class="text-lg font-black text-slate-900">Update Password</h2>
        <p class="mt-1 text-sm text-slate-500">Use a strong password to secure your account.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="ui-label">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" class="ui-input">
            @if($errors->updatePassword->has('current_password'))
                <p class="ui-field-error">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="ui-label">New Password</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" class="ui-input">
            @if($errors->updatePassword->has('password'))
                <p class="ui-field-error">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="ui-label">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="ui-input">
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="ui-field-error">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <x-ui.button type="submit">Update Password</x-ui.button>

            @if (session('status') === 'password-updated')
                <span class="text-sm font-semibold text-emerald-600">Saved.</span>
            @endif
        </div>
    </form>
</section>
