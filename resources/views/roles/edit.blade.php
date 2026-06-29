@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto py-10">

    <h1 class="text-2xl font-bold text-white mb-6">Edit Role</h1>

    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-4">

        @csrf
        @method('PUT')

        {{-- Role Name --}}
        <input type="text"
               name="name"
               value="{{ $role->name }}"
               class="w-full bg-gray-900 border border-gray-700 text-white p-3 rounded-xl">

        @error('name')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror

        {{-- Permissions --}}
        <div class="bg-gray-900 border border-gray-800 p-4 rounded-xl">

            <h2 class="text-white mb-3 font-semibold">
                Permissions
            </h2>

            <div class="grid grid-cols-2 gap-2 text-sm text-gray-300">

                @foreach($permissions as $permission)
                    <label class="flex items-center gap-2">

                        <input type="checkbox"
                               name="permissions[]"
                               value="{{ $permission->name }}"
                               class="accent-yellow-500"

                               {{-- 👇 لو permission موجودة في الرول --}}
                               @checked($role->hasPermissionTo($permission->name))
                        >

                        <span>{{ $permission->name }}</span>

                    </label>
                @endforeach

            </div>

        </div>

        <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-xl w-full">
            Update Role
        </button>

    </form>

</div>

@endsection