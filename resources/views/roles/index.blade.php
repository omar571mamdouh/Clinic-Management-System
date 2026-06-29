@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Roles</h1>

        <a href="{{ route('roles.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl">
            + Add Role
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 text-green-400 border border-green-500 p-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800">

        <table class="w-full text-white">

            <thead class="bg-gray-800">
                <tr>
                    <th class="text-left p-4">Role Name</th>
                    <th class="text-left p-4">Permissions</th>
                    <th class="text-right p-4">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($roles as $role)
                    <tr class="border-t border-gray-800">

                        {{-- Role Name --}}
                        <td class="p-4 font-semibold">
                            {{ $role->name }}
                        </td>

                        {{-- Permissions --}}
                        <td class="p-4">
                            <div class="flex flex-wrap gap-2">

                                @forelse($role->permissions as $permission)
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-500 text-sm">No permissions</span>
                                @endforelse

                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="p-4 text-right space-x-3">

                            <a href="{{ route('roles.edit', $role->id) }}"
                               class="text-yellow-400">Edit</a>

                            <form action="{{ route('roles.destroy', $role->id) }}"
                                  method="POST"
                                  class="inline">

                                @csrf
                                @method('DELETE')

                                <button class="text-red-400"
                                        onclick="return confirm('Delete role?')">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection