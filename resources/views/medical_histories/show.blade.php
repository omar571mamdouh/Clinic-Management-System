{{-- resources/views/medical-records/show.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Back button --}}
    <div class="mb-6">
        <a href="{{ route('medical-records.index') }}" 
           class="inline-flex items-center text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Records
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm rounded-2xl border border-gray-700 overflow-hidden">
        
        {{-- Header with status --}}
        <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 px-6 py-4 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white">
                    Medical Record Details
                </h2>
                <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-semibold">
                    Record #{{ $record->id }}
                </span>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-6">
            
            {{-- Patient & Doctor Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Patient Card --}}
                <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Patient Information</h3>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm"><span class="text-gray-400">Name:</span> <span class="text-white font-medium">{{ $record->patient->name ?? 'N/A' }}</span></p>
                        <p class="text-sm"><span class="text-gray-400">Email:</span> <span class="text-white">{{ $record->patient->email ?? 'N/A' }}</span></p>
                        @if($record->patient->phone)
                            <p class="text-sm"><span class="text-gray-400">Phone:</span> <span class="text-white">{{ $record->patient->phone }}</span></p>
                        @endif
                    </div>
                </div>

                {{-- Doctor Card --}}
                <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-purple-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Doctor Information</h3>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm"><span class="text-gray-400">Name:</span> <span class="text-white font-medium">{{ $record->doctor->name ?? 'N/A' }}</span></p>
                        <p class="text-sm"><span class="text-gray-400">Email:</span> <span class="text-white">{{ $record->doctor->email ?? 'N/A' }}</span></p>
                        @if($record->doctor->specialization)
                            <p class="text-sm"><span class="text-gray-400">Specialization:</span> <span class="text-white">{{ $record->doctor->specialization }}</span></p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Medical Details --}}
            <div class="space-y-6">
                {{-- Diagnosis --}}
                <div class="bg-red-500/5 rounded-xl p-4 border border-red-500/20">
                    <div class="flex items-center space-x-2 mb-3">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-red-400">Diagnosis</h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed">{{ $record->diagnosis ?? 'No diagnosis recorded' }}</p>
                </div>

                {{-- Treatment --}}
                <div class="bg-green-500/5 rounded-xl p-4 border border-green-500/20">
                    <div class="flex items-center space-x-2 mb-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-green-400">Treatment Plan</h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed">{{ $record->treatment ?? 'No treatment recorded' }}</p>
                </div>

                {{-- Notes --}}
                @if($record->notes)
                    <div class="bg-yellow-500/5 rounded-xl p-4 border border-yellow-500/20">
                        <div class="flex items-center space-x-2 mb-3">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-yellow-400">Additional Notes</h3>
                        </div>
                        <p class="text-gray-300 leading-relaxed">{{ $record->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Footer with metadata --}}
            <div class="mt-8 pt-6 border-t border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-6">
                        @if($record->visit_fee)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500">Visit Fee</p>
                                    <p class="text-lg font-bold text-green-400">${{ number_format($record->visit_fee, 2) }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Created</p>
                                <p class="text-sm text-white">{{ $record->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>

                        @if($record->updated_at != $record->created_at)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-500">Last Updated</p>
                                    <p class="text-sm text-white">{{ $record->updated_at->format('F d, Y \a\t h:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex space-x-3">
                        @can('update', $record)
                        <a href="{{ route('medical-records.edit', $record) }}" 
                           class="px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500 hover:text-white transition-all duration-200">
                            Edit Record
                        </a>
                        @endcan
                        
                        @can('delete', $record)
                        <form action="{{ route('medical-records.destroy', $record) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this medical record?')"
                                    class="px-4 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-200">
                                Delete
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection