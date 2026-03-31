<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border-gray-300">
            </div>

            <div class="flex justify-between items-center mb-4">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>

                <a href="#" class="text-sm text-blue-600">Forgot?</a>
            </div>

            <button class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold">
                Login
            </button>

            <p class="text-center text-sm mt-4">
                No account?
                <a href="{{ route('register') }}" class="text-blue-600">Register</a>
            </p>

        </form>
    </div>
</x-guest-layout>