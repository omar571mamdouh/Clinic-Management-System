<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Specialization filter
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        $doctors = $query->latest()->paginate(12);

        // Statistics - تأكد من وجود كل المفاتيح
        $stats = [
            'total' => Doctor::count(),
            'specializations' => Doctor::whereNotNull('specialization')->distinct('specialization')->count('specialization'),
            'avg_experience' => round(Doctor::avg('experience_years') ?? 0, 1),
            'new_this_month' => Doctor::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count(),
            'with_experience' => Doctor::whereNotNull('experience_years')->count(),
        ];

        // Get all unique specializations for filter dropdown
        $specializations = Doctor::whereNotNull('specialization')
                                ->distinct()
                                ->pluck('specialization')
                                ->filter()
                                ->values();

        return view('doctors.index', compact('doctors', 'stats', 'specializations'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('doctors', 'public');
        }

        Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully');
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($doctor->avatar) {
                Storage::disk('public')->delete($doctor->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('doctors', 'public');
        }

        $doctor->update($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        
        // Delete avatar if exists
        if ($doctor->avatar) {
            Storage::disk('public')->delete($doctor->avatar);
        }
        
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully');
    }
}