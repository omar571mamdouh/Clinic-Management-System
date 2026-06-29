@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold text-white">
            Doctor Details
        </h1>

        <a href="{{ route('doctors.index') }}"
           class="bg-gray-700 px-4 py-2 rounded text-white">
            Back
        </a>

    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 text-gray-300">

        <h2 class="text-xl text-white font-bold mb-4">
            {{ $doctor->name }}
        </h2>

        <p class="mb-2">Email: {{ $doctor->email ?? '-' }}</p>
        <p class="mb-2">Phone: {{ $doctor->phone ?? '-' }}</p>
        <p class="mb-2">Specialization: {{ $doctor->specialization ?? '-' }}</p>
        <p class="mb-2">Experience: {{ $doctor->experience_years ?? 0 }} years</p>
        <p class="mb-2">Address: {{ $doctor->address ?? '-' }}</p>

        <div class="mt-6 flex gap-3">

            <a href="{{ route('doctors.edit', $doctor->id) }}"
               class="bg-yellow-600 px-4 py-2 rounded text-white">
                Edit
            </a>

            <a href="{{ route('doctors.index') }}"
               class="bg-gray-700 px-4 py-2 rounded text-white">
                Back
            </a>

        </div>

    </div>

</div>

@endsection