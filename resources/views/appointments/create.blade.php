@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-3xl font-bold text-white mb-2">
        Book Appointment
    </h1>

    <p class="text-gray-400 mb-6">
        Create a new clinic appointment
    </p>

    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-xl mb-6">

            <ul class="list-disc pl-5 space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <form method="POST"
          action="{{ route('appointments.store') }}"
          class="bg-[#111827] border border-gray-800 p-6 rounded-2xl space-y-5">

        @csrf

        {{-- Patient --}}
        <div>

            <label class="block text-gray-400 text-sm mb-2">
                Patient
            </label>

            <select name="patient_id"
                    class="w-full bg-gray-800 text-white p-3 rounded-xl border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600">

                <option value="">Select patient</option>

                @foreach($patients as $patient)

                    <option value="{{ $patient->id }}"
                        {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

                        {{ $patient->name }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Doctor --}}
        <div>

            <label class="block text-gray-400 text-sm mb-2">
                Doctor
            </label>

            <select name="doctor_id"
                    class="w-full bg-gray-800 text-white p-3 rounded-xl border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600">

                <option value="">Select doctor</option>

                @foreach($doctors as $doctor)

                    <option value="{{ $doctor->id }}"
                        {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>

                        {{ $doctor->name }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Date --}}
        <div>

            <label class="block text-gray-400 text-sm mb-2">
                Appointment Date
            </label>

            <input type="date"
                   name="appointment_date"
                   min="{{ date('Y-m-d') }}"
                   value="{{ old('appointment_date') }}"
                   class="w-full bg-gray-800 text-white p-3 rounded-xl border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600">

        </div>

        {{-- Time --}}
        <div>

            <label class="block text-gray-400 text-sm mb-2">
                Appointment Time
            </label>

           <select name="appointment_time" id="time_slots" class="w-full bg-gray-800 text-white p-3 rounded-xl border border-gray-700">
    <option value="">Select time</option>
</select>

        </div>

        {{-- Notes --}}
        <div>

            <label class="block text-gray-400 text-sm mb-2">
                Notes
            </label>

            <textarea name="notes"
                      rows="4"
                      placeholder="Optional notes..."
                      class="w-full bg-gray-800 text-white p-3 rounded-xl border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('notes') }}</textarea>

        </div>

        {{-- Submit --}}
        <div class="pt-2">

            <button
                class="bg-blue-600 hover:bg-blue-700 transition px-6 py-3 rounded-xl text-white font-medium">

                Book Appointment

            </button>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const doctorSelect = document.querySelector('select[name="doctor_id"]');
    const dateInput    = document.querySelector('input[name="appointment_date"]');
    const timeSelect   = document.getElementById('time_slots');

    function fetchSlots() {

        const doctorId = doctorSelect.value;
        const date     = dateInput.value;

        if (!doctorId || !date) return;

        fetch(`/appointments/available-slots?doctor_id=${doctorId}&date=${date}`)
            .then(res => res.json())
            .then(data => {

                timeSelect.innerHTML = '';

                if (!data.length) {
                    timeSelect.innerHTML = `<option>No available slots</option>`;
                    return;
                }

                data.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                });

            });
    }

    doctorSelect.addEventListener('change', fetchSlots);
    dateInput.addEventListener('change', fetchSlots);
fetchSlots();
});

</script>


@endsection

