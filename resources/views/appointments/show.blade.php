{{-- resources/views/appointments/show.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto py-10">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Appointment Details</h1>
        <a href="{{ route('appointments.index') }}"
           class="text-gray-400 hover:text-white transition text-sm">
            ← Back
        </a>
    </div>

    <div class="bg-[#111827] border border-gray-800 p-6 rounded-2xl space-y-4 text-gray-300">

        <div class="grid grid-cols-2 gap-4">

            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Patient</p>
                <p class="font-semibold">{{ $appointment->patient->name }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Doctor</p>
                <p class="font-semibold">{{ $appointment->doctor->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Date</p>
                <p class="font-semibold">{{ $appointment->appointment_date }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Time</p>
                <p class="font-semibold">{{ $appointment->appointment_time }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Status</p>
                <span class="px-3 py-1 rounded-lg text-xs
                    @if($appointment->status == 'pending') bg-yellow-600
                    @elseif($appointment->status == 'confirmed') bg-blue-600
                    @elseif($appointment->status == 'done') bg-green-600
                    @elseif($appointment->status == 'cancelled') bg-red-600
                    @else bg-gray-600 @endif">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Notes</p>
                <p>{{ $appointment->notes ?? '-' }}</p>
            </div>

        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-800">
         @if($appointment->status === 'done')
    <a href="{{ route('medical-histories.create', $appointment->id) }}"
       class="bg-green-600 px-3 py-1 rounded">
        Add Medical Record
    </a>
@endif
            <a href="{{ route('appointments.edit', $appointment->id) }}"
               class="bg-yellow-600 hover:bg-yellow-700 px-4 py-2 rounded-lg text-white text-sm transition">
                Edit
            </a>

            <form method="POST"
                  action="{{ route('appointments.destroy', $appointment->id) }}">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white text-sm transition">
                    Delete
                </button>
            </form>
        </div>

    </div>

</div>

@endsection