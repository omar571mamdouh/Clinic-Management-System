@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-8">

    <h1 class="text-3xl font-bold text-white mb-6">
        Create User
    </h1>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6">

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="text-gray-300 text-sm">Name</label>
                <input type="text" name="name"
                       class="w-full bg-gray-800 text-white p-3 rounded-lg mt-2">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="text-gray-300 text-sm">Email</label>
                <input type="email" name="email"
                       class="w-full bg-gray-800 text-white p-3 rounded-lg mt-2">
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="text-gray-300 text-sm">Password</label>
                <input type="password" name="password"
                       class="w-full bg-gray-800 text-white p-3 rounded-lg mt-2">
            </div>

            {{-- Role --}}
            <div class="mb-6">
                <label class="text-gray-300 text-sm">Role</label>

                <select name="role"
                        class="w-full bg-gray-800 text-white p-3 rounded-lg mt-2">

                    <option value="">Select Role</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">
                            {{ $role->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">
                Create User
            </button>

        </form>

    </div>

</div>

@endsection