<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\MedicalHistory;
use App\Services\PaymentService;

class MedicalHistoryController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}
    public function index()
    {
        $records = MedicalHistory::with(['patient', 'doctor', 'appointment'])
            ->latest()
            ->paginate(10);

        return view('medical_histories.index', compact('records'));
    }

    public function create(Appointment $appointment)
    {
        return view('medical_histories.create', compact('appointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
            'visit_fee' => 'nullable|numeric|min:0',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        $medicalHistory = MedicalHistory::firstOrCreate(
            [
                'appointment_id' => $appointment->id,
            ],
            [
                'patient_id' => $appointment->patient_id,
                'doctor_id'  => $appointment->doctor_id,
                'diagnosis'  => $request->diagnosis,
                'treatment'  => $request->treatment,
                'notes'      => $request->notes,
                'visit_fee'  => $request->visit_fee,
            ]
        );

        // إنشاء أو تحديث الـ Payment بنفس قيمة الـ Visit Fee
        if ($request->filled('visit_fee')) {
            $this->paymentService->createForAppointment(
                $appointment,
                (float) $request->visit_fee
            );
        }

        return redirect()
            ->route('medical-records.show', $medicalHistory)
            ->with('success', 'Medical history created successfully!');
    }

    // Add the show method
    public function show(MedicalHistory $medicalHistory)
    {
        // Load relationships
        $record = $medicalHistory->load(['patient', 'doctor', 'appointment']);

        return view('medical_histories.show', compact('record'));
    }

    // Optional: Add edit method
    public function edit(MedicalHistory $medicalHistory)
    {
        return view('medical_histories.edit', compact('medicalHistory'));
    }

    // Optional: Add update method
    public function update(Request $request, MedicalHistory $medicalHistory)
    {
        $request->validate([
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
            'visit_fee' => 'nullable|numeric|min:0',
        ]);

        $medicalHistory->update([
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'notes' => $request->notes,
            'visit_fee' => $request->visit_fee,
        ]);

        return redirect()->route('medical-histories.show', $medicalHistory)
            ->with('success', 'Medical history updated successfully!');
    }

    // Optional: Add destroy method
    public function destroy(MedicalHistory $medicalHistory)
    {
        $medicalHistory->delete();

        return redirect()->route('medical-histories.index')
            ->with('success', 'Medical history deleted successfully!');
    }
}
