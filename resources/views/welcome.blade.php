{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Clinic System') }} - Healthcare Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    
    {{-- Navbar بسيط --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/80 backdrop-blur-md border-b border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center font-bold text-white text-sm">
                        +
                    </div>
                    <span class="text-white font-bold text-lg">Clinic System</span>
                </div>
                
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-slate-700 transition text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white text-sm font-medium transition shadow-lg">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="relative overflow-hidden">
        {{-- Background decoration --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-purple-500/5 to-pink-500/10"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="text-center">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-xs text-blue-400 font-medium">Smart Healthcare Management</span>
                </div>
                
                {{-- Main Title --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                    Modern Clinic
                    <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        Management System
                    </span>
                </h1>
                
                {{-- Description --}}
                <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-10">
                    Streamline your clinic operations with our comprehensive healthcare management solution. 
                    Manage patients, appointments, medical records, and more in one place.
                </p>
                
                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @guest
                        <a href="{{ route('register') }}" 
                           class="group relative inline-flex items-center gap-2 px-8 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                            Get Started
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" 
                           class="px-8 py-3 rounded-lg border border-slate-600 text-gray-300 font-semibold text-lg hover:bg-slate-800 hover:text-white transition-all duration-300">
                            Sign In
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                           class="px-8 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                            Go to Dashboard
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Why Choose Our System?</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Complete solution for modern healthcare facilities</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Feature 1 --}}
            <div class="group bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700 hover:border-blue-500/50 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Patient Management</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Easily manage patient information, medical history, and treatment records in one secure place.
                </p>
            </div>
            
            {{-- Feature 2 --}}
            <div class="group bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700 hover:border-purple-500/50 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Appointment Scheduling</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Smart appointment booking system with automated reminders and calendar integration.
                </p>
            </div>
            
            {{-- Feature 3 --}}
            <div class="group bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700 hover:border-green-500/50 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Medical Records</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Secure digital medical records with easy access to diagnosis, treatment, and prescriptions.
                </p>
            </div>
        </div>
    </div>

    {{-- Stats Section --}}
    <div class="bg-gradient-to-r from-blue-600/10 to-purple-600/10 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-white mb-1">500+</div>
                    <div class="text-sm text-gray-400">Happy Patients</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">20+</div>
                    <div class="text-sm text-gray-400">Expert Doctors</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">1k+</div>
                    <div class="text-sm text-gray-400">Appointments</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">100%</div>
                    <div class="text-sm text-gray-400">Secure</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-slate-900/50 border-t border-slate-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">© 2026 Clinic System. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-400 transition">Privacy Policy</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-400 transition">Terms of Service</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-400 transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Floating Animation --}}
    <div class="fixed bottom-6 right-6 opacity-30 pointer-events-none">
        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 blur-xl animate-pulse"></div>
    </div>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>