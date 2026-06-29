@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white">
            Add Patient
        </h1>

        <p class="text-gray-400 mt-1">
            Create a new patient profile
        </p>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8">

        <form action="{{ route('patients.store') }}" method="POST"
            enctype="multipart/form-data">

            @csrf

            @include('patients.form')

            <div class="mt-8 flex items-center gap-4">

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition">
                    Save Patient
                </button>

                <a href="{{ route('patients.index') }}"
                    class="text-gray-400 hover:text-white transition">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection