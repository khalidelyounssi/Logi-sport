<x-guest-layout>
    <x-ui.card padding="p-8 sm:p-10">
        <div class="mb-8 text-center">
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Account Recovery</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Reset Password</h1>
            <p class="mt-2 text-sm text-slate-500">Enter your email and we will send you a reset link.</p>
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

        <p class="mt-6 text-center text-sm text-slate-500">
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Back to login</a>
        </p>
    </x-ui.card>
</x-guest-layout>
