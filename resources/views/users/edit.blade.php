@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-8">

    <h1 class="text-3xl font-bold text-white mb-2">
        Edit User
    </h1>

    <p class="text-gray-400 mb-6">
        Assign or change role for {{ $user->name }}
    </p>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6">

        <form action="{{ route('users.update', $user->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Name (read-only) --}}
            <div class="mb-4">
                <label class="text-gray-300 text-sm">Name</label>
                <input type="text"
                       value="{{ $user->name }}"
                       disabled
                       class="w-full bg-gray-800 text-gray-300 p-3 rounded-lg">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="text-gray-300 text-sm">Email</label>
                <input type="text"
                       value="{{ $user->email }}"
                       disabled
                       class="w-full bg-gray-800 text-gray-300 p-3 rounded-lg">
            </div>

            {{-- Roles --}}
            <div class="mb-6">
                <label class="text-gray-300 text-sm">Assign Role</label>

                <select name="role"
                        class="w-full bg-gray-800 text-white p-3 rounded-lg mt-2">

                    <option value="">Select Role</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach

                </select>

                @error('role')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-6 py-3 rounded-xl font-semibold">
                Update User
            </button>

        </form>

    </div>

</div>

@endsection