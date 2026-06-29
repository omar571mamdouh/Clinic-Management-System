<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Create payment for appointment
     */
    public function createForAppointment(Appointment $appointment, float $amount): Payment
    {
        return DB::transaction(function () use ($appointment, $amount) {

            // prevent duplicate payment
            $payment = $appointment->payment()->updateOrCreate(
                [],
                [
                    'user_id' => $appointment->patient->user_id,
                    'amount' => $amount,
                    'status' => 'pending',
                    'method' => null,
                ]
            );

            return $payment;
        });
    }

    /**
     * Mark payment as paid
     */
    public function markAsPaid(Payment $payment): Payment
    {
        return DB::transaction(function () use ($payment) {

            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // sync with appointment
            $payment->appointment->update([
                'status' => 'confirmed',
            ]);

            return $payment;
        });
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(Payment $payment): Payment
    {
        return DB::transaction(function () use ($payment) {

            $payment->update([
                'status' => 'failed',
            ]);

            return $payment;
        });
    }

    /**
     * Get payment by appointment
     */
    public function getByAppointment(Appointment $appointment)
    {
        return $appointment->payment;
    }
}
