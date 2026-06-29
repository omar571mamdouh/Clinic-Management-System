{{-- resources/views/medical_histories/create.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-green-400 to-blue-500 bg-clip-text text-transparent">
                    Add Medical Record
                </h2>
                <p class="text-gray-400 mt-2">Create a new medical record for patient</p>
            </div>
            <a href="{{ route('medical-records.index') }}" 
               class="text-gray-400 hover:text-white transition-colors">
                ← Back
            </a>
        </div>
    </div>

    {{-- Appointment Info Card --}}
    @if(isset($appointment))
    <div class="bg-gradient-to-r from-blue-600/10 to-purple-600/10 rounded-xl p-4 mb-6 border border-blue-500/20">
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <div>
                <p class="text-sm text-gray-400">Creating record for appointment</p>
                <p class="text-white font-semibold">
                    {{ $appointment->patient->name ?? 'Patient' }} with Dr. {{ $appointment->doctor->name ?? 'Doctor' }}
                    <span class="text-xs text-gray-400 ml-2">
                        {{-- الحل: التحقق من وجود التاريخ وتحويله لكائن Carbon إذا لزم الأمر --}}
                        @php
                            $appointmentDate = $appointment->appointment_date;
                            if ($appointmentDate && !($appointmentDate instanceof \Carbon\Carbon)) {
                                $appointmentDate = \Carbon\Carbon::parse($appointmentDate);
                            }
                        @endphp
                        @if($appointmentDate)
                            {{ $appointmentDate->format('M d, Y') }}
                        @else
                            {{ $appointment->appointment_date ?? 'Date not set' }}
                        @endif
                    </span>
                </p>
            </div>
        </div>
    </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm rounded-2xl border border-gray-700 overflow-hidden">
        <form action="{{ route('medical-histories.store') }}" method="POST">
            @csrf

            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

            <div class="p-6 space-y-6">
                {{-- Diagnosis --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Diagnosis <span class="text-red-400">*</span>
                    </label>
                    <textarea name="diagnosis" 
                        rows="4"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-500"
                        placeholder="Enter patient diagnosis...">{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Treatment --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Treatment Plan <span class="text-red-400">*</span>
                    </label>
                    <textarea name="treatment" 
                        rows="4"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-500"
                        placeholder="Describe the treatment plan...">{{ old('treatment') }}</textarea>
                    @error('treatment')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Additional Notes
                    </label>
                    <textarea name="notes" 
                        rows="3"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-500"
                        placeholder="Any additional notes or observations...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Visit Fee --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Visit Fee ($)
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">$</span>
                        <input type="number" 
                            name="visit_fee"
                            step="0.01"
                            value="{{ old('visit_fee') }}"
                            class="w-full pl-8 pr-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white"
                            placeholder="0.00">
                    </div>
                    @error('visit_fee')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="px-6 py-4 bg-gray-900/50 border-t border-gray-700 flex items-center justify-end space-x-3">
                <a href="{{ route('medical-records.index') }}" 
                   class="px-4 py-2 text-gray-400 hover:text-white transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg hover:shadow-lg hover:shadow-green-500/25 transition-all duration-200">
                    Save Medical Record
                </button>
            </div>
        </form>
    </div>
</div>

@endsection