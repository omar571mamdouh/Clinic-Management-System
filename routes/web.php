<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;

Route::get('/', function () {
    return view('welcome');
});

// ========== Profile ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== Dashboard ==========
Route::middleware(['auth', 'permission:view dashboard'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ========== Users ==========
Route::middleware(['auth', 'permission:view users'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
});

// ========== Roles ==========
Route::middleware(['auth', 'permission:view roles'])->group(function () {
    Route::resource('roles', RoleController::class);
});

// ========== Patients ==========
Route::middleware(['auth', 'permission:view patients'])->group(function () {
    Route::get('patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});

Route::middleware(['auth', 'permission:create patients'])->group(function () {
    Route::get('patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('patients', [PatientController::class, 'store'])->name('patients.store');
});

Route::middleware(['auth', 'permission:edit patients'])->group(function () {
    Route::get('patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::post('patients/{patient}/medical-history', [PatientController::class, 'storeMedicalHistory'])
        ->name('patients.medical-history.store');
});

Route::middleware(['auth', 'permission:delete patients'])->group(function () {
    Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::delete('patients/{patient}/medical-history/{history}', [PatientController::class, 'destroyMedicalHistory'])
        ->name('patients.medical-history.destroy');
});

Route::middleware(['auth'])->group(function () {

    // ---- View ----
    Route::middleware('permission:view appointments')->group(function () {
        Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/available-slots', [AppointmentController::class, 'availableSlots']);
    });

    // ---- Create ---- (لازم يجي قبل {appointment})
    Route::middleware('permission:create appointments')->group(function () {
        Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    });

    // ---- Show ---- (بعد create عشان مش ياكل الـ URL)
    Route::middleware('permission:view appointments')->group(function () {
        Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    });

    // ---- Edit ----
    Route::middleware('permission:edit appointments')->group(function () {
        Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    });

    // ---- Delete ----
    Route::middleware('permission:delete appointments')->group(function () {
        Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    });
});
// ========== Medical Records ==========
Route::middleware(['auth', 'permission:view medical-records'])->group(function () {
    Route::get('/medical-histories', [MedicalHistoryController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-histories/{medicalHistory}', [MedicalHistoryController::class, 'show'])->name('medical-records.show');
});

Route::middleware(['auth', 'permission:create medical-records'])->group(function () {
    Route::get('/medical-histories/create/{appointment}', [MedicalHistoryController::class, 'create'])->name('medical-histories.create');
    Route::post('/medical-histories', [MedicalHistoryController::class, 'store'])->name('medical-histories.store');
});

// ========== Doctors ==========
Route::middleware(['auth'])->group(function () {

    Route::middleware('permission:create doctors')->group(function () {
        Route::get('doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
        Route::post('doctors', [DoctorController::class, 'store'])->name('doctors.store');
    });

    Route::middleware('permission:view doctors')->group(function () {
        Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
        Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
        Route::get('/doctors/{doctor}/schedule', [DoctorController::class, 'schedule'])->name('doctors.schedule');
        Route::get('/doctors/{doctor}/work-schedule', [DoctorScheduleController::class, 'index'])->name('doctor-schedules.index');
    });

});

Route::middleware(['auth', 'permission:edit doctors'])->group(function () {
    Route::get('doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::post('/doctors/{doctor}/work-schedule', [DoctorScheduleController::class, 'store'])->name('doctor-schedules.store');
    Route::put('/doctors/{doctor}/work-schedule/{schedule}', [DoctorScheduleController::class, 'update'])->name('doctor-schedules.update');
});

Route::middleware(['auth', 'permission:delete doctors'])->group(function () {
    Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::delete('/doctors/{doctor}/work-schedule/{schedule}', [DoctorScheduleController::class, 'destroy'])->name('doctor-schedules.destroy');
});

// ========== Visits & Prescriptions & Attachments ==========
Route::middleware(['auth', 'permission:create medical-records'])->group(function () {
    Route::post('/patients/{patient}/visits', [VisitController::class, 'store'])->name('patients.visits.store');
    Route::post('/visits/{visit}/prescriptions', [PrescriptionController::class, 'store'])->name('visits.prescriptions.store');
    Route::post('/visits/{visit}/attachments', [AttachmentController::class, 'store'])->name('visits.attachments.store');
});

Route::middleware(['auth', 'permission:delete medical-records'])->group(function () {
    Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
});
// ========== Activity Logs ==========

Route::middleware(['auth', 'permission:view activity-logs'])->group(function () {

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity-logs.index');

});

Route::middleware(['auth', 'permission:view payments'])->group(function () {

    Route::get('/payments/paynow/{payment}', [PaymentController::class, 'pay'])
        ->name('payments.paynow');

    Route::resource('payments', PaymentController::class)
        ->only(['index', 'show']);

});
Route::get('/payment/success', function () {
    return view('payments.success');
})->name('payments.success');

Route::post('/payment/webhook', [WebhookController::class, 'handle'])
    ->withoutMiddleware(['auth']);

// ========== Notifications ==========
Route::middleware(['auth', 'permission:view notifications'])->group(function () {

    Route::get('/notifications', fn() => response()->json(
        auth()->user()->unreadNotifications
    ))->name('notifications.index');

    Route::post('/notifications/{id}/read', fn($id) =>
        auth()->user()->notifications()->findOrFail($id)->markAsRead()
    )->name('notifications.read');

    Route::post('/notifications/read-all', fn() =>
        auth()->user()->unreadNotifications->markAsRead()
    )->name('notifications.read-all');

});

require __DIR__ . '/auth.php';
