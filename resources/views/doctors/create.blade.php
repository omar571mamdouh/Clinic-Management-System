@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-8">

    <div class="mb-6">
        <div class="flex items-center gap-2 mb-1">
            <div class="w-1 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full"></div>
            <h1 class="text-3xl font-bold text-white">
                Add Doctor
            </h1>
        </div>
        <p class="text-gray-400 mt-1 ml-3">
            Create a new doctor profile
        </p>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8">

        <form method="POST" action="{{ route('doctors.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Full Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition"
                       placeholder="Dr. Ahmed Mohamed">
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Email <span class="text-red-400">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition"
                       placeholder="doctor@example.com">
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition"
                       placeholder="+20 123 456 7890">
                @error('phone')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Specialization --}}
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Specialization</label>
                <input type="text" name="specialization" value="{{ old('specialization') }}"
                       class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition"
                       placeholder="Cardiology, Neurology, Pediatrics...">
                @error('specialization')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Experience Years --}}
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Experience (Years)</label>
                <input type="number" name="experience_years" value="{{ old('experience_years') }}"
                       class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition"
                       placeholder="5">
                @error('experience_years')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Address --}}
            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Address</label>
                <textarea name="address" rows="3"
                          class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition"
                          placeholder="Clinic address...">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Profile Picture --}}
            <div class="mb-6">
                <label class="block text-gray-400 text-sm mb-2">Profile Picture</label>
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-800 border-2 border-gray-700" id="avatarPreview">
                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="avatar" accept="image/*" id="avatarInput"
                               class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 transition file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        <p class="text-gray-500 text-xs mt-1">Recommended: Square image, max 2MB (JPG, PNG)</p>
                    </div>
                </div>
                @error('avatar')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-6 py-2.5 rounded-xl transition-all duration-300 shadow-md">
                    Save Doctor
                </button>
                <a href="{{ route('doctors.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2.5 rounded-xl transition-all duration-300">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
    // Preview avatar before upload
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('avatarPreview');
                preview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush