@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white">Payments</h1>
            <p class="text-gray-400">Manage all payments and their status</p>
        </div>
        <form method="GET" class="mt-4 md:mt-0">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search payments..."
                class="bg-gray-800 text-white p-3 rounded-lg w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-300">

                <thead class="text-gray-400 uppercase bg-gray-900">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Doctor</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                    <tr class="border-b border-gray-800 hover:bg-gray-800/40">

                        <td class="px-6 py-4 text-gray-400">
                            {{ $payment->id }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $payment->appointment->patient->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $payment->appointment->doctor->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-green-400">
                            ${{ number_format($payment->amount, 2) }}
                        </td>

                        <td class="px-6 py-4">
                            @if($payment->status == 'paid')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-500/20 text-green-400">Paid</span>
                            @elseif($payment->status == 'pending')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400">Pending</span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-red-500/20 text-red-400">Failed</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-400">
                            {{ $payment->created_at->format('Y-m-d') }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('payments.show', $payment->id) }}"
                                class="text-blue-400 hover:text-blue-300">View</a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-500">No payments found</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <div class="mt-6">{{ $payments->links() }}</div>

</div>
@endsection