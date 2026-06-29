<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Name --}}
    <div>
        <label class="block text-sm text-gray-300 mb-2">
            Full Name
        </label>

        <input type="text"
               name="name"
               value="{{ old('name', $patient->name ?? '') }}"
               class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">

        @error('name')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm text-gray-300 mb-2">
            Email
        </label>

        <input type="email"
               name="email"
               value="{{ old('email', $patient->email ?? '') }}"
               class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">

        @error('email')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Phone --}}
    <div>
        <label class="block text-sm text-gray-300 mb-2">
            Phone
        </label>

        <input type="text"
               name="phone"
               value="{{ old('phone', $patient->phone ?? '') }}"
               class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">

        @error('phone')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Age --}}
    <div>
        <label class="block text-sm text-gray-300 mb-2">
            Age
        </label>

        <input type="number"
               name="age"
               value="{{ old('age', $patient->age ?? '') }}"
               class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">

        @error('age')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Gender --}}
    <div class="md:col-span-2">
        <label class="block text-sm text-gray-300 mb-2">
            Gender
        </label>

        <select name="gender"
                class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">

            <option value="">Select Gender</option>

            <option value="male"
                {{ old('gender', $patient->gender ?? '') == 'male' ? 'selected' : '' }}>
                Male
            </option>

            <option value="female"
                {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>
                Female
            </option>

        </select>

        @error('gender')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Avatar --}}
<div class="md:col-span-2">
    <label class="block text-sm text-gray-300 mb-2">
        Patient Photo
    </label>

    @if(isset($patient) && $patient->avatar)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $patient->avatar) }}"
                 alt="{{ $patient->name }}"
                 class="w-24 h-24 rounded-xl object-cover border border-gray-700">
        </div>
    @endif

    <input type="file"
           name="avatar"
           accept="image/*"
           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white">

    <p class="text-xs text-gray-400 mt-2">
        JPG, PNG, WEBP (Max 2MB)
    </p>

    @error('avatar')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

    {{-- Address --}}
    <div class="md:col-span-2">
        <label class="block text-sm text-gray-300 mb-2">
            Address
        </label>

        <textarea name="address"
                  rows="3"
                  class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">{{ old('address', $patient->address ?? '') }}</textarea>
    </div>

    {{-- Notes --}}
    <div class="md:col-span-2">
        <label class="block text-sm text-gray-300 mb-2">
            Notes
        </label>

        <textarea name="notes"
                  rows="4"
                  class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">{{ old('notes', $patient->notes ?? '') }}</textarea>
    </div>

</div>