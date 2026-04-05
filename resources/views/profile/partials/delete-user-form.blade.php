<section class="space-y-4">
    <header>
        <h2 class="text-lg font-black text-slate-900">Delete Account</h2>
        <p class="mt-1 text-sm text-slate-500">
            This action is permanent. All associated data will be removed.
        </p>
    </header>

    <x-ui.button
        variant="danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        Delete Account
    </x-ui.button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-5 p-6">
            @csrf
            @method('delete')

            <div>
                <h3 class="text-lg font-black text-slate-900">Confirm Account Deletion</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Enter your password to permanently delete your account.
                </p>
            </div>

            <div>
                <label for="password" class="ui-label">Password</label>
                <input id="password" name="password" type="password" class="ui-input" placeholder="Password">
                @if($errors->userDeletion->has('password'))
                    <p class="ui-field-error">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="flex flex-wrap justify-end gap-2">
                <x-ui.button variant="secondary" x-on:click="$dispatch('close')">Cancel</x-ui.button>
                <x-ui.button variant="danger">Delete Account</x-ui.button>
            </div>
        </form>
    </x-modal>
</section>
