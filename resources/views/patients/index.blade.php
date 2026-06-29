{{-- Creative Patient Card Design with Circular Photo in Middle --}}
{{-- A modern, glass-morphism card layout perfect for clinic management systems --}}

@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">

    {{-- Header Section with Gradient Accent --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <div class="w-1 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full"></div>
                <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Patients</h1>
            </div>
            <p class="text-gray-400 mt-1 ml-3">Manage and track all clinic patients</p>
        </div>
        <a href="{{ route('patients.create') }}"
           class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-5 py-2.5 rounded-xl transition-all duration-300 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Add Patient</span>
        </a>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 backdrop-blur-sm animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistics Cards with Modern Design --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4 backdrop-blur-sm hover:border-gray-600 transition-all duration-300 group">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
            <p class="text-gray-400 text-sm mb-1 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Total
            </p>
            <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4 backdrop-blur-sm hover:border-gray-600 transition-all duration-300 group">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
            <p class="text-gray-400 text-sm mb-1 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Male
            </p>
            <p class="text-3xl font-bold text-blue-400">{{ $stats['male'] }}</p>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4 backdrop-blur-sm hover:border-gray-600 transition-all duration-300 group">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-pink-500/10 rounded-full blur-2xl group-hover:bg-pink-500/20 transition-all"></div>
            <p class="text-gray-400 text-sm mb-1 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Female
            </p>
            <p class="text-3xl font-bold text-pink-400">{{ $stats['female'] }}</p>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4 backdrop-blur-sm hover:border-gray-600 transition-all duration-300 group">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-green-500/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-all"></div>
            <p class="text-gray-400 text-sm mb-1 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                New This Month
            </p>
            <p class="text-3xl font-bold text-green-400">{{ $stats['new_this_month'] }}</p>
        </div>

    </div>

    {{-- Search & Filter Bar --}}
    <form method="GET" action="{{ route('patients.index') }}" class="flex flex-col sm:flex-row gap-3 mb-8">
        <div class="flex-1 relative group">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 group-focus-within:text-blue-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or phone..."
                   class="w-full bg-gray-900/80 border border-gray-700 rounded-xl pl-10 pr-4 py-2.5 text-gray-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"/>
        </div>

        <select name="gender"
                class="bg-gray-900/80 border border-gray-700 text-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all cursor-pointer">
            <option value="">All Genders</option>
            <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
        </select>

        <button type="submit"
                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-5 py-2.5 rounded-xl transition-all duration-300 shadow-md">
            Search
        </button>

        @if(request()->hasAny(['search', 'gender']))
            <a href="{{ route('patients.index') }}"
               class="bg-gray-700 hover:bg-gray-600 text-white px-5 py-2.5 rounded-xl transition-all duration-300 text-center">
                Clear
            </a>
        @endif
    </form>

    {{-- Creative Patient Cards Grid with Circular Photo in Middle --}}
    @if($patients->isEmpty())
        <div class="bg-gradient-to-br from-gray-900/50 to-gray-800/30 border border-gray-700 rounded-2xl py-16 text-center text-gray-500 backdrop-blur-sm">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4.13a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <p class="text-xl font-medium">No patients found</p>
            <p class="text-sm mt-1">Try adjusting your search or add a new patient</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach($patients as $patient)
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-800/70 rounded-2xl overflow-hidden transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-blue-500/10 border border-gray-700/50 hover:border-blue-500/30">

                    {{-- Decorative Background Blobs --}}
                    <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-all duration-500"></div>
                    <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-pink-500/5 rounded-full blur-2xl group-hover:bg-pink-500/10 transition-all duration-500"></div>

                    {{-- Top Badge Area --}}
                    <div class="flex justify-between items-start px-5 pt-5 relative z-10">
                        {{-- Age Badge --}}
                        <div class="flex items-center gap-1.5 bg-gray-800/80 backdrop-blur-sm rounded-full px-3 py-1 border border-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs text-gray-300">{{ $patient->age }} yrs</span>
                        </div>

                        {{-- Gender Badge --}}
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium backdrop-blur-sm
                            {{ $patient->gender === 'male' 
                                ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' 
                                : 'bg-pink-500/20 text-pink-300 border border-pink-500/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $patient->gender === 'male' ? 'bg-blue-400' : 'bg-pink-400' }}"></span>
                            {{ ucfirst($patient->gender) }}
                        </span>
                    </div>

                    {{-- Circular Avatar in the Middle --}}
                    <div class="flex justify-center mt-4 mb-3 relative z-10">
                        <div class="relative">
                            {{-- Outer Ring Animation --}}
                            <div class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 opacity-0 group-hover:opacity-100 blur-md transition-opacity duration-500"></div>
                            <div class="relative w-28 h-28 rounded-full overflow-hidden ring-4 ring-gray-800/80 group-hover:ring-blue-500/50 transition-all duration-300 shadow-xl">
                                @if($patient->avatar)
                                    <img src="{{ asset('storage/' . $patient->avatar) }}"
                                         alt="{{ $patient->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl font-bold
                                        {{ $patient->gender === 'male' 
                                            ? 'bg-gradient-to-br from-blue-600/30 to-indigo-600/30 text-blue-300' 
                                            : 'bg-gradient-to-br from-pink-600/30 to-rose-600/30 text-pink-300' }}">
                                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            {{-- Status Dot --}}
                            <div class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 rounded-full ring-2 ring-gray-900"></div>
                        </div>
                    </div>

                    {{-- Patient Info --}}
                    <div class="text-center px-4 mb-4 relative z-10">
                        <h3 class="text-white font-bold text-lg leading-tight mb-1 truncate">
                            {{ $patient->name }}
                        </h3>
                        
                        {{-- Phone with Icon --}}
                        <div class="flex items-center justify-center gap-1.5 mt-2">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <p class="text-gray-400 text-sm truncate">{{ $patient->phone }}</p>
                        </div>

                        {{-- Registration Date --}}
                        <div class="flex items-center justify-center gap-1.5 mt-1">
                            <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500 text-xs">Registered {{ $patient->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Action Buttons with Smooth Hover --}}
                    <div class="border-t border-gray-700/50 mt-2 pt-3 pb-4 px-5 flex items-center justify-between relative z-10 bg-gray-800/30">
                        <a href="{{ route('patients.show', $patient->id) }}"
                           class="group flex items-center gap-1.5 text-blue-400 hover:text-blue-300 text-sm font-medium transition-all">
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </a>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('patients.edit', $patient->id) }}"
                               class="group flex items-center gap-1 text-yellow-400 hover:text-yellow-300 text-sm font-medium transition-all">
                                <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>

                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this patient? This action cannot be undone.')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="group flex items-center gap-1 text-red-400 hover:text-red-300 text-sm font-medium transition-all">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Hover Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-500"></div>
                </div>
            @endforeach

        </div>
    @endif

    {{-- Pagination with Styling --}}
    @if($patients->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-gray-900/50 backdrop-blur-sm rounded-xl px-3 py-2 border border-gray-700">
                {{ $patients->appends(request()->query())->links() }}
            </div>
        </div>
    @endif

</div>

@endsection

@push('styles')
<style>
    {{-- Custom pagination styling to match dark theme --}}
    nav[role="navigation"] svg {
        @apply text-gray-400;
    }
    nav[role="navigation"] .relative span[aria-current="page"] span {
        @apply bg-blue-600 text-white border-blue-600;
    }
    nav[role="navigation"] .relative span:not([aria-current="page"]) span {
        @apply text-gray-400 border-gray-700 hover:bg-gray-800;
    }
</style>
@endpush