<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <input type="text" name="name" placeholder="Full Name"
                    class="w-full rounded-xl border-gray-300">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email"
                    class="w-full rounded-xl border-gray-300">
            </div>

            <!-- Role -->
            <div class="mb-4">
                <select name="role" class="w-full rounded-xl border-gray-300">
                    <option value="player">Player</option>
                    <option value="organizer">Organizer</option>
                    <option value="referee">Referee</option>
                </select>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password"
                    class="w-full rounded-xl border-gray-300">
            </div>

            <!-- Confirm -->
            <div class="mb-4">
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full rounded-xl border-gray-300">
            </div>

            <button class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold">
                Register
            </button>

            <p class="text-center text-sm mt-4">
                Already have account?
                <a href="{{ route('login') }}" class="text-blue-600">Login</a>
            </p>

        </form>
    </div>
</x-guest-layout>