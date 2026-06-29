{{-- resources/views/medical-records/index.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
            Medical Records
        </h2>
        <p class="text-gray-400 mt-2">Manage and view all patient medical records</p>
    </div>

    @if($records->count() == 0)
    <div class="text-center py-16 bg-gray-800/50 rounded-2xl border border-gray-700">
        <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-gray-400 text-lg">No medical records found</p>
        <p class="text-gray-500 text-sm mt-2">Medical records will appear here once created</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($records as $record)
        <div class="group bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 hover:border-blue-500/50 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300">

            {{-- Header with avatars --}}
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Patient</p>
                        <p class="font-semibold text-white text-sm">{{ $record->patient->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2 text-right">
                    <div>
                        <p class="text-xs text-gray-500">Doctor</p>
                        <p class="font-semibold text-white text-sm">{{ $record->doctor->name ?? '-' }}</p>
                    </div>
                    <div class="w-8 h-8 bg-purple-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Diagnosis --}}
            <div class="mb-3">
                <div class="flex items-center space-x-2 mb-1">
                    <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs font-semibold text-red-400 uppercase tracking-wider">Diagnosis</p>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed">
                    {{ Str::limit($record->diagnosis, 100) }}
                </p>
            </div>

            {{-- Treatment --}}
            <div class="mb-4">
                <div class="flex items-center space-x-2 mb-1">
                    <svg class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <p class="text-xs font-semibold text-green-400 uppercase tracking-wider">Treatment</p>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed">
                    {{ Str::limit($record->treatment, 100) }}
                </p>
            </div>

            {{-- Visit Fee + Payment --}}
            <div class="flex items-center justify-between pt-4 border-t border-gray-700">

                <div class="flex items-center space-x-2 text-xs text-gray-500">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $record->created_at->format('M d, Y') }}</span>
                </div>

                <div class="flex items-center space-x-3">

                    {{-- Fee --}}
                    @if($record->visit_fee)
                   
                    @endif

                    {{-- PAYMENT BUTTON --}}
                    @php
                    $payment = $record->appointment->payment ?? null;
                    @endphp

                    @if($payment && $payment->status === 'paid')
                    <span class="px-3 py-1 text-xs rounded-full bg-green-500/20 text-green-400">
                        Paid ✓
                    </span>

                    @elseif($payment)
                    <a href="{{ route('payments.show', $payment->id) }}"
                        class="px-3 py-1 text-xs rounded-lg bg-green-500 text-white hover:bg-green-600 transition">
                        Pay Now
                    </a>

                    @else
                    <span class="px-3 py-1 text-xs rounded-lg bg-gray-700 text-gray-400">
                        No Payment
                    </span>
                    @endif

                </div>
            </div>


            {{-- Actions --}}
            <div class="mt-4 flex items-center justify-end space-x-2">
                <a href="{{ route('medical-records.show', $record) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-400 hover:text-white bg-blue-400/10 hover:bg-blue-500 rounded-lg transition-colors duration-200">
                    View Details
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $records->links() }}
    </div>
</div>
@endsection