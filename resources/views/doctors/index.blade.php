@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">

    {{-- Header Section with Gradient Accent --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <div class="w-1 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full"></div>
                <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Doctors</h1>
            </div>
            <p class="text-gray-400 mt-1 ml-3">Manage all clinic doctors and specialists</p>
        </div>
        <a href="{{ route('doctors.create') }}"
           class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-5 py-2.5 rounded-xl transition-all duration-300 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Add Doctor</span>
        </a>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-6 backdrop-blur-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl"></div>
            <p class="text-gray-400 text-sm mb-1">Total Doctors</p>
            <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-purple-500/10 rounded-full blur-2xl"></div>
            <p class="text-gray-400 text-sm mb-1">Specializations</p>
            <p class="text-3xl font-bold text-purple-400">{{ $stats['specializations'] }}</p>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-green-500/10 rounded-full blur-2xl"></div>
            <p class="text-gray-400 text-sm mb-1">Avg Experience</p>
            <p class="text-3xl font-bold text-green-400">{{ $stats['avg_experience'] }} yrs</p>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900/80 to-gray-800/50 border border-gray-700/50 rounded-2xl px-5 py-4">
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-orange-500/10 rounded-full blur-2xl"></div>
            <p class="text-gray-400 text-sm mb-1">New This Month</p>
            <p class="text-3xl font-bold text-orange-400">{{ $stats['new_this_month'] }}</p>
        </div>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('doctors.index') }}" class="flex flex-col sm:flex-row gap-3 mb-8">
        <div class="flex-1 relative group">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 group-focus-within:text-blue-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, email or specialization..."
                   class="w-full bg-gray-900/80 border border-gray-700 rounded-xl pl-10 pr-4 py-2.5 text-gray-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"/>
        </div>

        <select name="specialization" class="bg-gray-900/80 border border-gray-700 text-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition-all cursor-pointer">
            <option value="">All Specializations</option>
            @foreach($specializations as $spec)
                <option value="{{ $spec }}" {{ request('specialization') === $spec ? 'selected' : '' }}>
                    {{ $spec }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-5 py-2.5 rounded-xl transition-all duration-300 shadow-md">
            Search
        </button>

        @if(request()->hasAny(['search', 'specialization']))
            <a href="{{ route('doctors.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-5 py-2.5 rounded-xl transition-all duration-300 text-center">
                Clear
            </a>
        @endif
    </form>

    {{-- Doctors Cards Grid (نفس تصميم Patients) --}}
    @if($doctors->isEmpty())
        <div class="bg-gradient-to-br from-gray-900/50 to-gray-800/30 border border-gray-700 rounded-2xl py-16 text-center text-gray-500 backdrop-blur-sm">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <p class="text-xl font-medium">No doctors found</p>
            <p class="text-sm mt-1">Try adjusting your search or add a new doctor</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($doctors as $doctor)
                <div class="group relative bg-gradient-to-br from-gray-900 to-gray-800/70 rounded-2xl overflow-hidden transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl hover:shadow-blue-500/10 border border-gray-700/50 hover:border-blue-500/30">

                    {{-- Decorative Background Blobs --}}
                    <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-all duration-500"></div>
                    <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 transition-all duration-500"></div>

                    {{-- Top Badge Area --}}
                    <div class="flex justify-between items-start px-5 pt-5 relative z-10">
                        {{-- Experience Badge --}}
                        <div class="flex items-center gap-1.5 bg-gray-800/80 backdrop-blur-sm rounded-full px-3 py-1 border border-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs text-gray-300">{{ $doctor->experience_years ?? 0 }} yrs exp</span>
                        </div>

                        {{-- Specialization Badge --}}
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium backdrop-blur-sm bg-blue-500/20 text-blue-300 border border-blue-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            {{ $doctor->specialization ?? 'General' }}
                        </span>
                    </div>

                    {{-- Circular Avatar in the Middle --}}
                    <div class="flex justify-center mt-4 mb-3 relative z-10">
                        <div class="relative">
                            {{-- Outer Ring Animation --}}
                            <div class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 opacity-0 group-hover:opacity-100 blur-md transition-opacity duration-500"></div>
                            <div class="relative w-28 h-28 rounded-full overflow-hidden ring-4 ring-gray-800/80 group-hover:ring-blue-500/50 transition-all duration-300 shadow-xl">
                                @if($doctor->avatar)
                                    <img src="{{ asset('storage/' . $doctor->avatar) }}"
                                         alt="{{ $doctor->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl font-bold bg-gradient-to-br from-blue-600/30 to-indigo-600/30 text-blue-300">
                                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            {{-- Status Dot --}}
                            <div class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 rounded-full ring-2 ring-gray-900"></div>
                        </div>
                    </div>

                    {{-- Doctor Info --}}
                    <div class="text-center px-4 mb-4 relative z-10">
                        <h3 class="text-white font-bold text-lg leading-tight mb-1 truncate">
                            {{ $doctor->name }}
                        </h3>
                        
                        <div class="flex items-center justify-center gap-1.5 mt-2">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-400 text-sm truncate">{{ $doctor->email ?? 'No email' }}</p>
                        </div>

                        <div class="flex items-center justify-center gap-1.5 mt-1">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <p class="text-gray-400 text-sm">{{ $doctor->phone ?? 'No phone' }}</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-gray-700/50 mt-2 pt-3 pb-4 px-5 flex items-center justify-between relative z-10 bg-gray-800/30">
                        <a href="{{ route('doctors.show', $doctor->id) }}"
                           class="group flex items-center gap-1.5 text-blue-400 hover:text-blue-300 text-sm font-medium transition-all">
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </a>

                        <div class="flex items-center gap-3">

    {{-- Schedule --}}
    <a href="{{ route('doctor-schedules.index', $doctor->id) }}"
       class="group flex items-center gap-1 text-cyan-400 hover:text-cyan-300 text-sm font-medium transition-all">

        <svg class="w-4 h-4 group-hover:scale-110 transition-transform"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>

        Schedule
    </a>

    {{-- Edit --}}
    <a href="{{ route('doctors.edit', $doctor->id) }}"
       class="group flex items-center gap-1 text-yellow-400 hover:text-yellow-300 text-sm font-medium transition-all">

        <svg class="w-4 h-4 group-hover:rotate-12 transition-transform"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>

        Edit
    </a>

    {{-- Delete --}}
    <form action="{{ route('doctors.destroy', $doctor->id) }}"
          method="POST"
          onsubmit="return confirm('Delete this doctor?')"
          class="inline">

        @csrf
        @method('DELETE')

        <button class="group flex items-center gap-1 text-red-400 hover:text-red-300 text-sm font-medium transition-all">

            <svg class="w-4 h-4 group-hover:scale-110 transition-transform"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/>
            </svg>

            Delete
        </button>

    </form>

</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Pagination --}}
    @if($doctors->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-gray-900/50 backdrop-blur-sm rounded-xl px-3 py-2 border border-gray-700">
                {{ $doctors->appends(request()->query())->links() }}
            </div>
        </div>
    @endif

</div>

@endsection