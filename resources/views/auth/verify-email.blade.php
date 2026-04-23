<x-guest-layout>
    <x-ui.card padding="p-8 sm:p-10">
        <div class="mb-8 text-center">
            <p class="ls-kicker">Email Verification</p>
            <h1 class="mt-4 text-3xl font-black text-white">Verify Your Email</h1>
            <p class="mt-3 text-sm leading-7 text-slate-400">Please confirm your email address before continuing.</p>
        </div>

        @if (session('status') === 'verification-link-sent')
            <x-ui.alert class="mb-5">
                A new verification link has been sent to your email address.
            </x-ui.alert>
        @endif

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-ui.button type="submit" class="w-full" size="lg">
                    Resend Verification Email
                </x-ui.button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-ui.button type="submit" variant="secondary" class="w-full" size="lg">
                    Logout
                </x-ui.button>
            </form>
        </div>
    </x-ui.card>
</x-guest-layout>
