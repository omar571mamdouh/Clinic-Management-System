<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\MedicalHistory;
use App\Models\User;
use App\Models\Payment;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Weekly data (last 7 days) ──
        $weekDays = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i));

        $weeklyLabels  = $weekDays->map(fn($d) => $d->format('D'))->toArray();

        $weeklyTotal   = $weekDays->map(fn($d) =>
            Appointment::whereDate('appointment_date', $d)->count()
        )->toArray();

        $weeklyDone    = $weekDays->map(fn($d) =>
            Appointment::whereDate('appointment_date', $d)->where('status', 'done')->count()
        )->toArray();

        $weeklyPending = $weekDays->map(fn($d) =>
            Appointment::whereDate('appointment_date', $d)->where('status', 'pending')->count()
        )->toArray();

        // ── Monthly data (current year) ──
        $months = collect(range(1, 12));

        $monthlyLabels   = $months->map(fn($m) => Carbon::create(null, $m)->format('M'))->toArray();

        $monthlyRecords  = $months->map(fn($m) =>
            MedicalHistory::whereYear('created_at', now()->year)->whereMonth('created_at', $m)->count()
        )->toArray();

        $monthlyPatients = $months->map(fn($m) =>
            Patient::whereYear('created_at', now()->year)->whereMonth('created_at', $m)->count()
        )->toArray();

        // ── Roles ──
        $roleStats = DB::table('roles')
            ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('roles.name', DB::raw('COUNT(model_has_roles.role_id) as users_count'))
            ->groupBy('roles.id', 'roles.name')
            ->get();

        // ── Payment stats ──
        $revenueMonthlyLabels  = $monthlyLabels;

        $revenueMonthlyPaid    = $months->map(fn($m) =>
            (float) Payment::where('status', 'paid')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('amount')
        )->toArray();

        $revenueMonthlyPending = $months->map(fn($m) =>
            (float) Payment::where('status', 'pending')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('amount')
        )->toArray();

        $revenueMonthlyFailed  = $months->map(fn($m) =>
            (float) Payment::where('status', 'failed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('amount')
        )->toArray();

        return view('dashboard', [
            // Stat cards
            'patientsCount'         => Patient::count(),
            'doctorsCount'          => Doctor::count(),
            'todayAppointments'     => Appointment::whereDate('appointment_date', today())->count(),
            'pendingAppointments'   => Appointment::where('status', 'pending')->count(),
            'completedAppointments' => Appointment::where('status', 'done')->count(),
            'cancelledAppointments' => Appointment::where('status', 'cancelled')->count(),
            'medicalRecordsCount'   => MedicalHistory::count(),
            'usersCount'            => User::count(),
            'unreadNotifications'   => Auth::user()->unreadNotifications->count(),

            // Today table
            'todayList' => Appointment::with(['patient', 'doctor'])
                ->whereDate('appointment_date', today())
                ->latest()
                ->get(),

            // Doctor workload
            'doctorWorkload' => Doctor::withCount('appointments')->orderByDesc('appointments_count')->get(),

            // Weekly chart
            'weeklyLabels'  => $weeklyLabels,
            'weeklyTotal'   => $weeklyTotal,
            'weeklyDone'    => $weeklyDone,
            'weeklyPending' => $weeklyPending,

            // Monthly chart
            'monthlyLabels'   => $monthlyLabels,
            'monthlyRecords'  => $monthlyRecords,
            'monthlyPatients' => $monthlyPatients,

            // Roles donut
            'roleStats' => $roleStats,

            // Activity log
            'recentActivities' => Activity::latest()->take(8)->get(),

            // Payment stats
            'totalRevenue'          => Payment::where('status', 'paid')->sum('amount'),
            'paidPayments'          => Payment::where('status', 'paid')->count(),
            'pendingPayments'       => Payment::where('status', 'pending')->count(),
            'failedPayments'        => Payment::where('status', 'failed')->count(),
            'revenueMonthlyLabels'  => $revenueMonthlyLabels,
            'revenueMonthlyPaid'    => $revenueMonthlyPaid,
            'revenueMonthlyPending' => $revenueMonthlyPending,
            'revenueMonthlyFailed'  => $revenueMonthlyFailed,
        ]);
    }
}