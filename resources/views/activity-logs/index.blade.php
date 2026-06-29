@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-medium text-slate-100 flex items-center gap-2">
            <i class="ti ti-list-details text-slate-500 text-xl"></i>
            Activity logs
        </h1>
        <span class="text-xs bg-slate-800 text-slate-400 border border-slate-700 rounded-full px-3 py-1">
            {{ $activities->total() }} entries
        </span>
    </div>

    <div class="rounded-2xl overflow-hidden border border-slate-800 bg-slate-950">
        <table class="w-full text-sm" style="table-layout: fixed;">
            <thead class="bg-slate-800/80 border-b border-slate-700">
                <tr>
                    <th class="px-4 py-2.5 text-left text-[10.5px] font-medium uppercase tracking-widest text-slate-500 w-[20%]">
                        <i class="ti ti-user text-[11px] mr-1.5"></i>User
                    </th>
                    <th class="px-4 py-2.5 text-left text-[10.5px] font-medium uppercase tracking-widest text-slate-500 w-[20%]">
                        <i class="ti ti-activity text-[11px] mr-1.5"></i>Action
                    </th>
                    <th class="px-4 py-2.5 text-left text-[10.5px] font-medium uppercase tracking-widest text-slate-500 w-[35%]">
                        <i class="ti ti-info-circle text-[11px] mr-1.5"></i>Details
                    </th>
                    <th class="px-4 py-2.5 text-left text-[10.5px] font-medium uppercase tracking-widest text-slate-500 w-[25%]">
                        <i class="ti ti-clock text-[11px] mr-1.5"></i>Date
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-800/80">
                @forelse($activities as $activity)
                    @php
                        $action = strtolower($activity->description);
                        $actionConfig = match(true) {
                            str_contains($action, 'created') => ['bg-green-950 text-green-400 border border-green-900', 'ti-circle-plus'],
                            str_contains($action, 'updated') => ['bg-blue-950 text-blue-400 border border-blue-900', 'ti-pencil'],
                            str_contains($action, 'deleted') => ['bg-red-950 text-red-400 border border-red-900', 'ti-trash'],
                            str_contains($action, 'login')   => ['bg-purple-950 text-purple-400 border border-purple-900', 'ti-login'],
                            default => ['bg-slate-800 text-slate-400 border border-slate-700', 'ti-activity'],
                        };

                        $name = $activity->causer?->name ?? 'System';
                        $initials = $name === 'System' ? null : collect(explode(' ', $name))->map(fn($w) => strtoupper($w[0]))->take(2)->join('');

                        // Properties
                        $props      = $activity->properties ?? collect();
                        $attrs      = $props->get('attributes', []);
                        $old        = $props->get('old', []);

                        $patient    = $attrs['patient_name']  ?? $props->get('patient_name')  ?? null;
                        $doctor     = $attrs['doctor_name']   ?? $props->get('doctor_name')   ?? null;
                        $newStatus  = $attrs['status']        ?? $props->get('status')        ?? null;
                        $oldStatus  = $old['status']          ?? null;
                    @endphp

                    <tr class="hover:bg-slate-800/50 transition-colors">

                        {{-- User --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                @if(!$initials)
                                    <div class="w-[30px] h-[30px] rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center flex-shrink-0">
                                        <i class="ti ti-settings text-slate-500 text-[13px]"></i>
                                    </div>
                                @else
                                    <div class="w-[30px] h-[30px] rounded-full bg-indigo-950 flex items-center justify-center flex-shrink-0">
                                        <span class="text-[11px] font-semibold text-indigo-400">{{ $initials }}</span>
                                    </div>
                                @endif
                                <span class="font-medium text-slate-100 truncate text-[13px]">{{ $name }}</span>
                            </div>
                        </td>

                        {{-- Action --}}
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $actionConfig[0] }}">
                                <i class="ti {{ $actionConfig[1] }} text-[13px]"></i>
                                {{ $activity->description }}
                            </span>
                        </td>

                        {{-- Details --}}
                        <td class="px-4 py-3">
                            <div class="flex flex-col gap-1.5">

                                @if($patient)
                                    <div class="flex items-center gap-1.5 text-[12px] text-slate-300">
                                        <i class="ti ti-user-heart text-slate-500 text-[12px]"></i>
                                        <span class="text-slate-500">Patient:</span>
                                        <span class="font-medium">{{ $patient }}</span>
                                    </div>
                                @endif

                                @if($doctor)
                                    <div class="flex items-center gap-1.5 text-[12px] text-slate-300">
                                        <i class="ti ti-stethoscope text-slate-500 text-[12px]"></i>
                                        <span class="text-slate-500">Doctor:</span>
                                        <span class="font-medium">{{ $doctor }}</span>
                                    </div>
                                @endif

                                @if($newStatus)
                                    <div class="flex items-center gap-1.5 text-[12px]">
                                        <i class="ti ti-circle-dot text-slate-500 text-[12px]"></i>
                                        <span class="text-slate-500">Status:</span>
                                        @if($oldStatus)
                                            <span class="text-slate-400 line-through text-[11px]">{{ $oldStatus }}</span>
                                            <i class="ti ti-arrow-right text-slate-600 text-[11px]"></i>
                                        @endif
                                        <span class="px-1.5 py-0.5 rounded text-[11px] font-medium
                                            {{ match(strtolower($newStatus)) {
                                                'active', 'confirmed', 'completed' => 'bg-green-950 text-green-400',
                                                'pending', 'waiting'               => 'bg-yellow-950 text-yellow-400',
                                                'cancelled', 'rejected', 'deleted' => 'bg-red-950 text-red-400',
                                                default                            => 'bg-slate-800 text-slate-400',
                                            } }}">
                                            {{ $newStatus }}
                                        </span>
                                    </div>
                                @endif

                                @if(!$patient && !$doctor && !$newStatus)
                                    <span class="text-slate-600 text-[12px] italic">No details</span>
                                @endif

                            </div>
                        </td>

                        {{-- Date --}}
                        <td class="px-4 py-3">
                            <div class="text-[13px] text-slate-200">{{ $activity->created_at->format('Y-m-d') }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">{{ $activity->created_at->format('h:i A') }}</div>
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-slate-500">
                            <i class="ti ti-mood-empty text-2xl block mb-2"></i>
                            No activity logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <span class="text-xs text-slate-500">
            Showing {{ $activities->firstItem() }}–{{ $activities->lastItem() }} of {{ $activities->total() }}
        </span>
        {{ $activities->links() }}
    </div>

</div>
@endsection