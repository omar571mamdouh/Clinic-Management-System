<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Anyone can view own payment
     */
    public function view(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id
            || $user->hasRole('admin');
    }

    /**
     * Only admin can create payments manually
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Only admin can update payment
     */
    public function update(User $user, Payment $payment): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Only admin can delete payment
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Webhook bypass (important)
     * Optional: allow system/internal updates
     */
    public function systemUpdate(): bool
    {
        return true;
    }
}
