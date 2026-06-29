<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MedicalHistory;
use App\Notifications\AppointmentCreatedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);

        // Search
        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('patient', function ($patientQuery) use ($search) {

                    $patientQuery->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                })->orWhereHas('doctor', function ($doctorQuery) use ($search) {

                    $doctorQuery->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                });
            });
        }

        // Filter by doctor
        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );
        }

        // Filter by status
        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        // Filter by date
        if ($request->appointment_date) {

            $query->whereDate(
                'appointment_date',
                $request->appointment_date
            );
        }

        $appointments = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $doctors = Doctor::all();

        return view(
            'appointments.index',
            compact('appointments', 'doctors')
        );
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors  = Doctor::all();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'       => ['required', 'exists:patients,id'],
            'doctor_id'        => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required'],
            'notes'            => ['nullable', 'string'],
        ]);

        $doctorId = $request->doctor_id;
        $date     = $request->appointment_date;
        $time     = $request->appointment_time;

        $appointmentDateTime = strtotime($date . ' ' . $time);

        // 1. منع الحجز في الماضي
        if ($appointmentDateTime < now()->timestamp) {
            return back()->withErrors([
                'appointment_time' => 'Cannot book an appointment in the past.'
            ])->withInput();
        }

        // 2. التحقق من جدول الدكتور الأسبوعي
        $day = \Carbon\Carbon::parse($date)->format('l');

        $schedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day', $day)
            ->first();

        if (!$schedule) {
            return back()->withErrors([
                'appointment_date' => 'Doctor is not available on this day.'
            ])->withInput();
        }

        // 3. التحقق إن الوقت داخل شيفت الدكتور
        $start = strtotime($date . ' ' . $schedule->start_time);
        $end   = strtotime($date . ' ' . $schedule->end_time);

        if ($appointmentDateTime < $start || $appointmentDateTime > $end) {
            return back()->withErrors([
                'appointment_time' => 'Selected time is outside doctor working hours.'
            ])->withInput();
        }

        // 4. منع التداخل مع حجوزات نفس اليوم
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->get();

        foreach ($appointments as $appointment) {

            $existingTime = strtotime(
                $appointment->appointment_date . ' ' . $appointment->appointment_time
            );

            $difference = abs($appointmentDateTime - $existingTime) / 60;

            if ($difference < 30) {
                return back()->withErrors([
                    'appointment_time' => 'Doctor already has an appointment within 30 minutes.'
                ])->withInput();
            }
        }

        // 5. إنشاء الموعد
        $appointment = Appointment::create([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $doctorId,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'notes'            => $request->notes,
            'status'           => 'pending',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->on($appointment)
            ->withProperties([
                'patient_name' => $appointment->patient->name,
                'doctor_name'  => $appointment->doctor->name,
                'status'       => $appointment->status,
            ])
            ->log('Created appointment');

        $appointment->load(['patient', 'doctor']);

        // 6. Notifications
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(
                new AppointmentCreatedNotification($appointment)
            );
        }

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment created successfully');
    }
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor']);

        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors  = Doctor::all();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id'       => ['required', 'exists:patients,id'],
            'doctor_id'        => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'notes'            => ['nullable', 'string'],
            'status'           => ['required', 'in:pending,confirmed,cancelled,done'],
        ]);

        //  منع تعديل المواعيد النهائية
        if (in_array($appointment->status, ['done', 'cancelled'])) {
            return back()->withErrors([
                'status' => 'Cannot modify a completed or cancelled appointment.'
            ]);
        }

        //  منع التداخل في الحجز
        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'appointment_date' => 'This doctor is already booked at this time.'
            ])->withInput();
        }

        //  1. تحديث الموعد أولاً
        $appointment->update([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes'            => $request->notes,
            'status'           => $request->status,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($appointment)
            ->withProperties([
                'patient' => $appointment->patient->name,
                'doctor' => $appointment->doctor->name,
                'status' => $appointment->status,
            ])
            ->log('Updated appointment');

        //  2. لو اتحول Done → اعمل Medical History مرة واحدة فقط
        if ($request->status === 'done' && !$appointment->medicalHistory) {

            $medicalHistory = MedicalHistory::create([
                'appointment_id' => $appointment->id,
                'patient_id'     => $appointment->patient_id,
                'doctor_id'      => $appointment->doctor_id,
                'visit_fee'      => 500,
            ]);

            // 🔥 هنا أهم سطر
            $payment = $appointment->payment()->create([
                'amount' => $medicalHistory->visit_fee,
                'status' => 'pending',
                'patient_id' => $appointment->patient_id,
            ]);
        }

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment updated successfully');
    }

    public function destroy(Appointment $appointment)
    {
        // منع حذف موعد confirmed
        if ($appointment->status === 'confirmed') {
            return back()->withErrors([
                'status' => 'Cannot delete a confirmed appointment. Cancel it first.'
            ]);
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($appointment)
            ->withProperties([
                'patient' => $appointment->patient->name,
                'doctor'  => $appointment->doctor->name,
                'status'  => $appointment->status,
            ])
            ->log('Deleted appointment');
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment deleted successfully');
    }


    public function availableSlots(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date     = $request->date;

        if (!$doctorId || !$date) {
            return response()->json([]);
        }

        $day = Carbon::parse($date)->format('l');

        $schedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day', $day)
            ->first();

        if (!$schedule) {
            return response()->json([]);
        }

        $booked = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->map(fn($t) => date('H:i', strtotime($t)))
            ->toArray();

        $start = Carbon::createFromFormat('H:i:s', $schedule->start_time);
        $end   = Carbon::createFromFormat('H:i:s', $schedule->end_time);

        $slots = [];

        while ($start->lt($end)) {

            $time = $start->format('H:i');

            if (!in_array($time, $booked)) {
                $slots[] = $time;
            }

            $start->addMinutes(30);
        }

        return response()->json($slots);
    }
}
