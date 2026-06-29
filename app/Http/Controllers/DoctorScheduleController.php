<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index(Doctor $doctor)
    {
        $schedules = $doctor->schedules()
            ->orderBy('day')
            ->get();

        return view(
            'doctor-schedules.index',
            compact('doctor', 'schedules')
        );
    }

    public function store(Request $request, Doctor $doctor)
    {
        $request->validate([
            'day'        => ['required'],
            'start_time' => ['required'],
            'end_time'   => ['required', 'after:start_time'],
        ]);

        $exists = DoctorSchedule::where(
                'doctor_id',
                $doctor->id
            )
            ->where(
                'day',
                $request->day
            )
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'day' => 'Schedule already exists for this day.'
            ]);
        }

        DoctorSchedule::create([
            'doctor_id'  => $doctor->id,
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
        ]);

        return back()->with(
            'success',
            'Schedule added successfully.'
        );
    }

    public function update(
        Request $request,
        Doctor $doctor,
        DoctorSchedule $schedule
    ) {
        $request->validate([
            'day'        => ['required'],
            'start_time' => ['required'],
            'end_time'   => ['required', 'after:start_time'],
        ]);

        $schedule->update([
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
        ]);

        return back()->with(
            'success',
            'Schedule updated successfully.'
        );
    }

    public function destroy(
        Doctor $doctor,
        DoctorSchedule $schedule
    ) {
        $schedule->delete();

        return back()->with(
            'success',
            'Schedule deleted successfully.'
        );
    }
}