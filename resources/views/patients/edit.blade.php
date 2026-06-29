@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white">
            Edit Patient
        </h1>

        <p class="text-gray-400 mt-1">
            Update patient information
        </p>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8">

        <form action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            @include('patients.form')

            <div class="mt-8 flex items-center gap-4">

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-black px-6 py-3 rounded-xl transition font-semibold">
                    Update Patient
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