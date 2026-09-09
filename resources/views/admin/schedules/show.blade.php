@extends('admin.layout')

@section('title', 'Detail Jadwal Pelatihan - Admin CMS')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.schedules.index') }}" class="text-[#94A3B8] hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-[#F1F5F9] font-space uppercase tracking-wider">Detail Jadwal</h1>
    </div>

    <div class="bg-[#0B1526] border border-[#1E324E] divide-y divide-[#1E324E]">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-space uppercase text-[#94A3B8]">Layanan Pelatihan</span>
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
            </div>
            <h2 class="text-xl font-bold text-[#F1F5F9]">{{ $schedule->service->name }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 p-6 gap-6">
            <div>
                <label class="block text-[10px] uppercase font-space text-[#94A3B8] mb-1">Kota</label>
                <p class="text-sm text-[#F1F5F9]">{{ $schedule->city->name }}</p>
            </div>
            <div>
                <label class="block text-[10px] uppercase font-space text-[#94A3B8] mb-1">Tanggal</label>
                <p class="text-sm text-[#F1F5F9] font-mono">{{ $schedule->date->format('d M Y') }}</p>
            </div>
            <div>
                <label class="block text-[10px] uppercase font-space text-[#94A3B8] mb-1">Waktu</label>
                <p class="text-sm text-[#F1F5F9] font-mono">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
            </div>
            <div>
                <label class="block text-[10px] uppercase font-space text-[#94A3B8] mb-1">Kuota</label>
                <p class="text-sm text-[#F1F5F9] font-mono">{{ $schedule->available_slots }} Orang</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-[10px] uppercase font-space text-[#94A3B8] mb-1">Lokasi Lengkap</label>
                <p class="text-sm text-[#F1F5F9]">{{ $schedule->location }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-[10px] uppercase font-space text-[#94A3B8] mb-1">Catatan</label>
                <p class="text-sm text-[#F1F5F9] italic">{{ $schedule->notes ?? 'Tidak ada catatan tambahan.' }}</p>
            </div>
        </div>

        <div class="p-6 bg-[#0F2038] flex justify-end gap-3">
            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn-secondary px-4 py-2 text-xs uppercase font-space">
                Edit Jadwal
            </a>
            <a href="{{ route('admin.schedules.index') }}" class="btn-primary px-4 py-2 text-xs uppercase font-space">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection