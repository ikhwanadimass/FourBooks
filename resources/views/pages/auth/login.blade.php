<x-layouts::auth.login :title="__('Log in')">
    <!-- Dark Card Container - Landscape Rectangle Like Photo -->
    <div class="bg-black/50 rounded-2xl p-16 backdrop-blur-sm w-full max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-6xl font-bold text-white tracking-tight">
                Login
                <span class="text-blue-500">Fourbooks</span>
            </h1>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login.store') }}" class="space-y-8">
            @csrf

            <!-- Email Address Input -->
            <div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="Username"
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
                    autocomplete="current-password"
                    placeholder="Password"
                    class="w-full rounded-lg border-0 bg-gray-300 px-6 py-5 text-gray-700 text-base placeholder-gray-400 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all"
                />
                @error('password')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Login Button -->
            <button
                type="submit"
                class="w-full rounded-lg bg-blue-600 px-8 py-5 font-bold text-lg text-gray-800 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-black/50 transition-all duration-200 mt-10 shadow-lg"
            >
                Log In
            </button>

            <!-- Register Link -->
            <div class="text-center mt-8">
                <p class="text-gray-300 text-base">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-500 font-semibold hover:text-blue-400 transition-colors">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-layouts::auth.login>
