@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8">

    {{-- Back --}}
    <a href="{{ route('patients.index') }}"
       class="inline-flex items-center gap-2 text-gray-400 hover:text-white mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Patients
    </a>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="bg-green-500/15 border border-green-500 text-green-400 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Patient Info Card --}}
    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 mb-8">

        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $patient->name }}</h1>
                <p class="text-gray-400 mt-0.5">Patient Profile</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('medical-records.index', $patient->id) }}"
                   class="bg-green-500/15 text-green-400 hover:bg-green-500/25 px-4 py-2 rounded-xl text-sm transition">
                    Medical History
                </a>
                <a href="{{ route('patients.edit', $patient->id) }}"
                   class="bg-yellow-500/15 text-yellow-400 hover:bg-yellow-500/25 px-4 py-2 rounded-xl text-sm transition">
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Phone</p>
                <p class="text-gray-200">{{ $patient->phone }}</p>
            </div>

            @if($patient->email)
            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Email</p>
                <p class="text-gray-200">{{ $patient->email }}</p>
            </div>
            @endif

            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Age</p>
                <p class="text-gray-200">{{ $patient->age }} years</p>
            </div>

            <div>
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Gender</p>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium
                    {{ $patient->gender === 'male'
                        ? 'bg-blue-500/15 text-blue-400'
                        : 'bg-pink-500/15 text-pink-400' }}">
                    {{ ucfirst($patient->gender) }}
                </span>
            </div>

            @if($patient->address)
            <div class="col-span-2">
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Address</p>
                <p class="text-gray-200">{{ $patient->address }}</p>
            </div>
            @endif

            @if($patient->notes)
            <div class="col-span-3">
                <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Notes</p>
                <p class="text-gray-300 text-sm">{{ $patient->notes }}</p>
            </div>
            @endif

        </div>
    </div>

    {{-- Appointments Section --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-white">Appointments</h2>
            <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}"
               class="text-blue-400 hover:text-blue-300 text-sm transition">
                + New Appointment
            </a>
        </div>

        @if($appointments->isNotEmpty())
            <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-[#1f2937] text-gray-300 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Doctor</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-300">
                        @foreach($appointments as $appointment)
                            <tr class="border-t border-gray-800">
                                <td class="px-6 py-3">{{ $appointment->appointment_date }}</td>
                                <td class="px-6 py-3">{{ $appointment->doctor->name ?? '—' }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $appointment->status === 'completed' ? 'bg-green-500/15 text-green-400' : '' }}
                                        {{ $appointment->status === 'pending' ? 'bg-yellow-500/15 text-yellow-400' : '' }}
                                        {{ $appointment->status === 'cancelled' ? 'bg-red-500/15 text-red-400' : '' }}">
                                        {{ ucfirst($appointment->status ?? 'Scheduled') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 text-center text-gray-500">
                No appointments found for this patient.
            </div>
        @endif
    </div>

</div>

@endsection