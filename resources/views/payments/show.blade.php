@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">

    <div class="bg-[#111827] border border-gray-800 rounded-2xl shadow-lg overflow-hidden">

        {{-- Header --}}
        <div class="px-8 py-6 border-b border-gray-800 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">Payment Details</h1>
                <p class="text-gray-400 mt-1">Payment #{{ $payment->id }}</p>
            </div>

            @if($payment->status === 'paid')
                <span class="px-4 py-2 rounded-full bg-green-500/20 text-green-400 text-sm font-semibold">Paid ✓</span>
            @elseif($payment->status === 'pending')
                <span class="px-4 py-2 rounded-full bg-yellow-500/20 text-yellow-400 text-sm font-semibold">Pending</span>
            @else
                <span class="px-4 py-2 rounded-full bg-red-500/20 text-red-400 text-sm font-semibold">Failed</span>
            @endif
        </div>

        {{-- Body --}}
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-gray-400 text-sm">Patient</p>
                <p class="text-white font-semibold text-lg">
                    {{ $payment->appointment->patient->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Doctor</p>
                <p class="text-white font-semibold text-lg">
                    {{ $payment->appointment->doctor->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Amount</p>
                <p class="text-green-400 font-bold text-2xl">
                    ${{ number_format($payment->amount, 2) }}
                </p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Appointment Date</p>
                <p class="text-white font-semibold">
                    {{ optional($payment->appointment)->appointment_date }}
                </p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Created At</p>
                <p class="text-white">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Transaction ID</p>
                <p class="text-white font-mono text-sm">
                    {{ $payment->transaction_id ?? 'Not assigned yet' }}
                </p>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-8 py-6 border-t border-gray-800 flex justify-end gap-3">
            <a href="{{ route('payments.index') }}"
                class="px-5 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition">
                Back
            </a>

            @if($payment->status === 'pending')
                <a href="{{ route('payments.paynow', $payment->id) }}"
                    class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold transition">
                    Pay Now
                </a>
            @endif
        </div>

    </div>
</div>
@endsection