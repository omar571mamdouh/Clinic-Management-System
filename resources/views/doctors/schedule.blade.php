@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-white">
                Dr. {{ $doctor->name }} Schedule
            </h1>

            <p class="text-gray-400 mt-1">
                All appointments for this doctor
            </p>
        </div>

        <a href="{{ route('doctors.index') }}"
           class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg text-white">
            Back
        </a>

    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-[#111827] border border-gray-800 p-4 rounded-xl text-white">
            Total Appointments: {{ $appointments->count() }}
        </div>

        <div class="bg-[#111827] border border-gray-800 p-4 rounded-xl text-yellow-400">
            Pending: {{ $appointments->where('status','pending')->count() }}
        </div>

        <div class="bg-[#111827] border border-gray-800 p-4 rounded-xl text-green-400">
            Done: {{ $appointments->where('status','done')->count() }}
        </div>

    </div>

    {{-- Table --}}
    <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden">

        <table class="w-full text-left text-gray-300">

            <thead class="bg-[#1f2937] text-gray-400 text-sm uppercase">
                <tr>
                    <th class="px-6 py-4">Patient</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Time</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Notes</th>
                </tr>
            </thead>

            <tbody>

                @forelse($appointments as $appointment)

                <tr class="border-t border-gray-800 hover:bg-gray-800/40">

                    <td class="px-6 py-4 text-white">
                        {{ $appointment->patient->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $appointment->appointment_date }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $appointment->appointment_time }}
                    </td>

                    <td class="px-6 py-4">

                        <span class="px-3 py-1 rounded-lg text-xs
                            @if($appointment->status == 'pending') bg-yellow-600
                            @elseif($appointment->status == 'done') bg-green-600
                            @elseif($appointment->status == 'cancelled') bg-red-600
                            @else bg-gray-600 @endif">

                            {{ $appointment->status }}

                        </span>

                    </td>

                    <td class="px-6 py-4 text-gray-400">
                        {{ $appointment->notes ?? '-' }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-500">
                        No appointments found for this doctor
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection