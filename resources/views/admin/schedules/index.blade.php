@extends('admin.layout')

@section('title', 'Manajemen Jadwal Pelatihan - Admin CMS')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#F1F5F9] font-space uppercase tracking-wider">Jadwal Pelatihan</h1>
            <p class="text-xs text-[#94A3B8]">Kelola jadwal, kuota, dan lokasi pelatihan K3 Nasional</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="btn-primary px-4 py-2 text-xs font-space uppercase">
            + Buat Jadwal Baru
        </a>
    </div>

    <div class="bg-[#0B1526] border border-[#1E324E] rounded-sm overflow-hidden">
        <div class="p-4 border-b border-[#1E324E] bg-[#0F2038] flex flex-col sm:flex-row gap-4 items-center justify-between">
            <form action="{{ route('admin.schedules.index') }}" method="GET" class="flex w-full sm:w-auto gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari layanan, kota, atau lokasi..." class="input-k3 text-xs w-full sm:w-64">
                <button type="submit" class="btn-secondary px-3 py-2 text-xs uppercase font-space">Cari</button>
            </form>
            <div class="text-[10px] text-[#94A3B8] uppercase font-space">
                Total: {{ $schedules->total() }} Jadwal
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans border-collapse">
                <thead class="bg-[#0F2038] border-b border-[#1E324E] text-[#94A3B8] font-space uppercase text-[11px] tracking-wider">
                    <tr>
                        <th class="p-3">Layanan</th>
                        <th class="p-3">Kota</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Waktu</th>
                        <th class="p-3">Lokasi</th>
                        <th class="p-3 text-center">Kuota</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142338]">
                    @forelse($schedules as $schedule)
                    <tr class="bg-[#070D18] hover:bg-[#0B1526] transition group">
                        <td class="p-3 font-medium text-[#F1F5F9]">{{ $schedule->service->name }}</td>
                        <td class="p-3 text-[#94A3B8]">{{ $schedule->city->name }}</td>
                        <td class="p-3 font-mono text-[#F1F5F9]">{{ $schedule->date->format('d M Y') }}</td>
                        <td class="p-3 font-mono text-[#94A3B8]">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                        <td class="p-3 text-[#94A3B8]">{{ Str::limit($schedule->location, 30) }}</td>
                        <td class="p-3 text-center font-mono">{{ $schedule->available_slots }}</td>
                        <td class="p-3 text-center">
                            @php
                                $statusClass = match($schedule->status) {
                                    'open' => 'text-[#10B981] bg-[#06201B] border-[#0D7A5F]',
                                    'closed' => 'text-[#EF4444] bg-[#200606] border-[#7F1D1D]',
                                    'completed' => 'text-[#38BDF8] bg-[#061B20] border-[#075985]',
                                    default => 'text-[#94A3B8] bg-[#0B1526] border-[#1E324E]',
                                };
                            @endphp
                            <span class="px-2 py-0.5 border rounded-full text-[10px] uppercase font-space {{ $statusClass }}">
                                {{ $schedule->status }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('admin.schedules.show', $schedule->id) }}" class="text-[#94A3B8] hover:text-white">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5.757 12 5.757c4.477 0 8.268 2.186 9.542 6.243C21.542 12 21.542 12 21.542 12s0 0-4.084 6.243C18.477 18 14.477 18 12 18c-2.477 0-6.477-2.186-9.542-6.243z"/></svg>
                            </a>
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="text-[#38BDF8] hover:text-white">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="p-4 text-center text-[#94A3B8]">Tidak ada jadwal ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $schedules->withQueryString()->links() }}
    </div>
</div>

@endsection

