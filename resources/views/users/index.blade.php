@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Users</h1>
            <p class="text-gray-400 mt-1">Manage system users and roles</p>
        </div>

        <a href="{{ route('users.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl">
            + Add User
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-[#1f2937] text-gray-300">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Created</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)

                <tr class="border-t border-gray-800">

                    <td class="px-6 py-4 text-white">
                        {{ $user->name }}
                    </td>

                    <td class="px-6 py-4 text-gray-300">
                        {{ $user->email }}
                    </td>

                    <td class="px-6 py-4">
                        @foreach($user->getRoleNames() as $role)
                        <span class="px-2 py-1 text-xs rounded bg-blue-500/20 text-blue-300">
                            {{ $role }}
                        </span>
                        @endforeach
                    </td>

                    <td class="px-6 py-4 text-gray-400">
                        {{ $user->created_at->diffForHumans() }}
                    </td>

                    <td class="px-6 py-4 text-right flex justify-end gap-3">

                        <a href="{{ route('users.edit', $user->id) }}"
                            class="text-yellow-400 hover:text-yellow-300">
                            Edit
                        </a>

                        <form action="{{ route('users.destroy', $user->id) }}"
                            method="POST"
                            onsubmit="return confirm('Delete user?')">

                            @csrf
                            @method('DELETE')

                            <button class="text-red-400 hover:text-red-300">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-500">
                        No users found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection