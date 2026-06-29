{{-- resources/views/appointments/edit.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-2xl font-bold text-white mb-6">Edit Appointment</h1>

    @if($errors->any())
        <div class="bg-red-500/15 border border-red-500 text-red-400 px-4 py-3 rounded-xl mb-5">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('appointments.update', $appointment->id) }}"
          class="bg-[#111827] border border-gray-800 p-6 rounded-2xl space-y-4">

        @csrf
        @method('PUT')

        {{-- Patient --}}
        <div>
            <label class="text-gray-400 text-sm">Patient</label>
            <select name="patient_id"
                    class="w-full mt-1 bg-gray-800 text-white p-3 rounded-lg">
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Doctor --}}
        <div>
            <label class="text-gray-400 text-sm">Doctor</label>
            <select name="doctor_id"
                    class="w-full mt-1 bg-gray-800 text-white p-3 rounded-lg">
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}"
                        {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Date --}}
        <div>
            <label class="text-gray-400 text-sm">Date</label>
            <input type="date"
                   name="appointment_date"
                   value="{{ $appointment->appointment_date }}"
                   class="w-full mt-1 bg-gray-800 text-white p-3 rounded-lg">
        </div>

        {{-- Time --}}
        <div>
            <label class="text-gray-400 text-sm">Time</label>
            <input type="time"
                   name="appointment_time"
                   value="{{ $appointment->appointment_time }}"
                   class="w-full mt-1 bg-gray-800 text-white p-3 rounded-lg">
        </div>

        {{-- Status --}}
        <div>
            <label class="text-gray-400 text-sm">Status</label>
            <select name="status"
                    class="w-full mt-1 bg-gray-800 text-white p-3 rounded-lg">
                @foreach(['pending', 'confirmed', 'cancelled', 'done'] as $status)
                    <option value="{{ $status }}"
                        {{ $appointment->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Notes --}}
        <div>
            <label class="text-gray-400 text-sm">Notes</label>
            <textarea name="notes"
                      class="w-full mt-1 bg-gray-800 text-white p-3 rounded-lg"
                      placeholder="Optional notes...">{{ $appointment->notes }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white transition">
                Update
            </button>
            <a href="{{ route('appointments.index') }}"
               class="bg-gray-700 hover:bg-gray-600 px-6 py-2 rounded-lg text-white transition">
                Cancel
            </a>
        </div>

    </form>

</div>

@endsection