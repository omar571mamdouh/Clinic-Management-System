<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // هنسيبها true ونسيب التحكم للPolicy
        return true;
    }

    public function rules(): array
    {
        return [
            'appointment_id' => ['required', 'exists:appointments,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'method' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_id.required' => 'Appointment is required',
            'appointment_id.exists' => 'Appointment not found',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
        ];
    }
}