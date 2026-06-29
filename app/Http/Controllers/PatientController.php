<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource with search & stats.
     */
    public function index(Request $request)
    {
        $query = Patient::latest();

        // Search by name or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $patients = $query->paginate(10)->withQueryString();

        // Statistics
        $stats = [
            'total'   => Patient::count(),
            'male'    => Patient::where('gender', 'male')->count(),
            'female'  => Patient::where('gender', 'female')->count(),
            'new_this_month' => Patient::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('patients.index', compact('patients', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'name'    => 'required|max:255',
        'email'   => 'nullable|email',
        'phone'   => 'required',
        'age'     => 'required|integer',
        'gender'  => 'required',
        'address' => 'nullable',
        'notes'   => 'nullable',
        'avatar'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('avatar')) {
        $data['avatar'] = $request->file('avatar')->store('patients', 'public');
    }

    Patient::create($data);

    return redirect()->route('patients.index')
        ->with('success', 'Patient added successfully');
}

    /**
     * Display the specified resource with appointments & medical history.
     */
    public function show(Patient $patient)
    {
        $appointments = $patient->appointments()
            ->with('doctor')
            ->latest()
            ->get();

        $medicalHistories = $patient->medicalHistories()
            ->latest()
            ->get();

        return view('patients.show', compact('patient', 'appointments', 'medicalHistories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
{
    $data = $request->validate([
        'name'    => 'required|max:255',
        'email'   => 'nullable|email',
        'phone'   => 'required',
        'age'     => 'required|integer',
        'gender'  => 'required',
        'address' => 'nullable',
        'notes'   => 'nullable',
        'avatar'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('avatar')) {

        if ($patient->avatar) {
            Storage::disk('public')->delete($patient->avatar);
        }

        $data['avatar'] = $request->file('avatar')->store('patients', 'public');
    } else {
        $data['avatar'] = $patient->avatar;
    }

    $patient->update($data);

    return redirect()->route('patients.index')
        ->with('success', 'Patient updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully');
    }

    // ─────────────────────────────────────────
    //  Medical History
    // ─────────────────────────────────────────

    /**
     * Store a new medical history record for a patient.
     */
    public function storeMedicalHistory(Request $request, Patient $patient)
    {
        $request->validate([
            'diagnosis'   => 'required|max:500',
            'treatment'   => 'nullable|max:500',
            'doctor_name' => 'nullable|max:255',
            'visit_date'  => 'required|date',
            'notes'       => 'nullable',
        ]);

        $patient->medicalHistories()->create($request->only([
            'diagnosis',
            'treatment',
            'doctor_name',
            'visit_date',
            'notes'
        ]));

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Medical record added successfully');
    }

    /**
     * Delete a medical history record.
     */
    public function destroyMedicalHistory(Patient $patient, MedicalHistory $history)
    {
        $history->delete();

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Medical record deleted');
    }
}
