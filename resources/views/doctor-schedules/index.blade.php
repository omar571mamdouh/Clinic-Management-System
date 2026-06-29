@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8">

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-white">
            Doctor Schedule
        </h1>

        <p class="text-gray-400 mt-1">
            {{ $doctor->name }}
        </p>

    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Add Schedule --}}

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 mb-8">

        <h2 class="text-white text-lg font-semibold mb-4">
            Add Schedule
        </h2>

        <form
            action="{{ route('doctor-schedules.store', $doctor->id) }}"
            method="POST"
            class="grid md:grid-cols-4 gap-4">

            @csrf

            <select
                name="day"
                class="bg-gray-800 text-white p-3 rounded-lg">

                <option value="">Select Day</option>

                <option>Saturday</option>
                <option>Sunday</option>
                <option>Monday</option>
                <option>Tuesday</option>
                <option>Wednesday</option>
                <option>Thursday</option>
                <option>Friday</option>

            </select>

            <input
                type="time"
                name="start_time"
                class="bg-gray-800 text-white p-3 rounded-lg">

            <input
                type="time"
                name="end_time"
                class="bg-gray-800 text-white p-3 rounded-lg">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                Add

            </button>

        </form>

    </div>

    {{-- Schedule Table --}}

    <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-[#1f2937] text-gray-300">

                <tr>
                    <th class="px-6 py-4">Day</th>
                    <th class="px-6 py-4">Start</th>
                    <th class="px-6 py-4">End</th>
                    <th class="px-6 py-4">Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse($schedules as $schedule)

                    <tr class="border-t border-gray-800">

                        <td class="px-6 py-4">
                            {{ $schedule->day }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $schedule->start_time }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $schedule->end_time }}
                        </td>

                        <td class="px-6 py-4">

                            <form
                                action="{{ route('doctor-schedules.destroy', [$doctor->id, $schedule->id]) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete schedule?')"
                                    class="text-red-400">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="text-center py-8 text-gray-500">

                            No schedules found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection