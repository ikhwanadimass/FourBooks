<x-layouts::auth.login :title="__('Register')">
    <!-- Dark Card Container - Landscape Rectangle Like Photo -->
    <div class="bg-black/50 rounded-2xl p-16 backdrop-blur-sm w-full max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-6xl font-bold text-white tracking-tight">
                Register
                <span class="text-blue-500">Fourbooks</span>
            </h1>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register.store') }}" class="space-y-8">
            @csrf

            <!-- Name Input -->
            <div>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Full Name"
                    class="w-full rounded-lg border-0 bg-gray-300 px-6 py-5 text-gray-700 text-base placeholder-gray-400 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all"
                />
                @error('name')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address Input -->
            <div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="Email Address"
                    class="w-full rounded-lg border-0 bg-gray-300 px-6 py-5 text-gray-700 text-base placeholder-gray-400 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all"
                />
                @error('email')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                    class="w-full rounded-lg border-0 bg-gray-300 px-6 py-5 text-gray-700 text-base placeholder-gray-400 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all"
                />
                @error('password')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                    class="w-full rounded-lg border-0 bg-gray-300 px-6 py-5 text-gray-700 text-base placeholder-gray-400 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all"
                />
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Register Button -->
            <button
                type="submit"
                class="w-full rounded-lg bg-blue-600 px-8 py-5 font-bold text-lg text-gray-800 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-black/50 transition-all duration-200 mt-10 shadow-lg"
            >
                Create Account
            </button>
        </form>

        <!-- Already Have Account Link -->
        <div class="text-center mt-8">
            <p class="text-gray-400 text-sm">
                {{ __('Sudah punya akun?') }}
                <a href="{{ route('login') }}" class="text-blue-500 font-medium hover:text-blue-400 transition-colors">
                    {{ __('Log in') }}
                </a>
            </p>
        </div>
    </div>
</x-layouts::auth.login>
