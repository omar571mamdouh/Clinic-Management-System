@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-10">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-white">
                Appointments
            </h1>

            <p class="text-gray-400 mt-1">
                Manage clinic appointments
            </p>
        </div>

        <a href="{{ route('appointments.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">
            + New Appointment
        </a>

    </div>

    <form method="GET"
      action="{{ route('appointments.index') }}"
      class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">

    {{-- Search --}}
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Search patient or doctor..."
           class="bg-gray-800 text-white p-3 rounded-lg border border-gray-700">

    {{-- Doctor Filter --}}
    <select name="doctor_id"
            class="bg-gray-800 text-white p-3 rounded-lg border border-gray-700">

        <option value="">All Doctors</option>

        @foreach($doctors as $doctor)

            <option value="{{ $doctor->id }}"
                {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>

                {{ $doctor->name }}

            </option>

        @endforeach

    </select>

    {{-- Status Filter --}}
    <select name="status"
            class="bg-gray-800 text-white p-3 rounded-lg border border-gray-700">

        <option value="">All Status</option>

        <option value="pending"
            {{ request('status') == 'pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="confirmed"
            {{ request('status') == 'confirmed' ? 'selected' : '' }}>
            Confirmed
        </option>

        <option value="done"
            {{ request('status') == 'done' ? 'selected' : '' }}>
            Done
        </option>

        <option value="cancelled"
            {{ request('status') == 'cancelled' ? 'selected' : '' }}>
            Cancelled
        </option>

    </select>

    {{-- Date Filter --}}
    <input type="date"
           name="appointment_date"
           value="{{ request('appointment_date') }}"
           class="bg-gray-800 text-white p-3 rounded-lg border border-gray-700">

    <div class="md:col-span-4 flex gap-3">

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            Filter
        </button>

        <a href="{{ route('appointments.index') }}"
           class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
            Reset
        </a>

    </div>

</form>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-green-500/15 border border-green-500 text-green-400 px-4 py-3 rounded-xl mb-5">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden">

        <table class="w-full text-left text-gray-300">

            <thead class="bg-[#1f2937] text-sm uppercase text-gray-400">
                <tr>
                    <th class="px-6 py-4">Patient</th>
                    <th class="px-6 py-4">Doctor</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Time</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($appointments as $appointment)

                <tr class="border-t border-gray-800 hover:bg-gray-800/40 transition">

                    <td class="px-6 py-4">
                        {{ $appointment->patient->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $appointment->doctor->name ?? '-' }}
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

                    <td class="px-6 py-4">

                        <div class="flex gap-3 items-center">

                            {{-- View --}}
                            <a href="{{ route('appointments.show', $appointment->id) }}"
                                class="px-3 py-1 rounded-lg border border-blue-500 text-blue-400 hover:bg-blue-500/10 transition text-sm">
                                View
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('appointments.edit', $appointment->id) }}"
                                class="px-3 py-1 rounded-lg border border-yellow-500 text-yellow-400 hover:bg-yellow-500/10 transition text-sm">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form method="POST"
                                action="{{ route('appointments.destroy', $appointment->id) }}"
                                onsubmit="return confirm('Are you sure?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="px-3 py-1 rounded-lg border border-red-500 text-red-400 hover:bg-red-500/10 transition text-sm">
                                    Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-500">
                        No appointments found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
@if($appointments->hasPages())
<div class="mt-6 flex items-center justify-between text-sm text-gray-400">

    {{-- Results Info --}}
    <span>
        Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }}
        of {{ $appointments->total() }} results
    </span>

    {{-- Buttons --}}
    <div class="flex items-center gap-1">

        {{-- Previous --}}
        @if($appointments->onFirstPage())
            <span class="px-3 py-2 rounded-lg bg-gray-800 text-gray-600 cursor-not-allowed">
                &laquo;
            </span>
        @else
            <a href="{{ $appointments->previousPageUrl() }}"
               class="px-3 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-white transition">
                &laquo;
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
            @if($page == $appointments->currentPage())
                <span class="px-3 py-2 rounded-lg bg-blue-600 text-white font-semibold">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}"
                   class="px-3 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 transition">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($appointments->hasMorePages())
            <a href="{{ $appointments->nextPageUrl() }}"
               class="px-3 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-white transition">
                &raquo;
            </a>
        @else
            <span class="px-3 py-2 rounded-lg bg-gray-800 text-gray-600 cursor-not-allowed">
                &raquo;
            </span>
        @endif

    </div>

</div>
@endif

</div>

@endsection