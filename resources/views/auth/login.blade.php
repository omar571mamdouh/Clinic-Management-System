{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-[#0f172a] px-4 py-12">

        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
                <p class="text-gray-400 text-sm mt-2">Sign in to your account</p>
            </div>

            {{-- Form --}}
            <div class="bg-[#111827] rounded-2xl border border-gray-800 p-6 shadow-xl">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-sm text-gray-300 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full h-11 rounded-xl bg-[#1f2937] border border-gray-700 text-white px-4 focus:ring-2 focus:ring-blue-600 outline-none"
                               placeholder="Enter your email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs"/>
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="block text-sm text-gray-300 mb-2">Password</label>
                        <input type="password" name="password" required
                               class="w-full h-11 rounded-xl bg-[#1f2937] border border-gray-700 text-white px-4 focus:ring-2 focus:ring-blue-600 outline-none"
                               placeholder="Enter your password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs"/>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-[#1f2937] border-gray-700 text-blue-600 focus:ring-blue-600">
                            <span class="text-sm text-gray-400">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    {{-- Button --}}
                    <button type="submit"
                            class="w-full h-11 rounded-xl bg-blue-700 hover:bg-blue-600 transition text-white font-semibold shadow-lg shadow-blue-900/40">
                        Sign In
                    </button>

                    {{-- Register Link --}}
                    <p class="text-center text-gray-400 text-sm mt-6">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium">
                        Create Account
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</x-guest-layout>