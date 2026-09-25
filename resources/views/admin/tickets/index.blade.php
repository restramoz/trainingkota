@extends('admin.layout')

@section('title', 'Kelola Tiket Konsultasi & WhatsApp')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-space text-[#F1F5F9]">Kelola Tiket Masuk &amp; WhatsApp</h1>
            <p class="text-xs text-[#94A3B8] mt-1">Daftar permohonan konsultasi teknis K3 dan dispatch langsung ke WhatsApp Official.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tickets.create') }}" class="bg-[#0D7A5F] hover:bg-[#10B981] text-white px-4 py-2 rounded-lg text-xs font-semibold font-space flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Tiket Manual
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-[#0E1726] border border-[#1E293B] p-4 rounded-xl">
            <span class="text-xs text-[#94A3B8] uppercase font-space">Total Tiket</span>
            <div class="text-2xl font-bold font-space text-[#F1F5F9] mt-1">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-[#0E1726] border border-[#1E293B] p-4 rounded-xl border-l-4 border-l-amber-500">
            <span class="text-xs text-amber-400 uppercase font-space">Pending / Baru</span>
            <div class="text-2xl font-bold font-space text-amber-400 mt-1">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-[#0E1726] border border-[#1E293B] p-4 rounded-xl border-l-4 border-l-blue-500">
            <span class="text-xs text-blue-400 uppercase font-space">Dalam Proses</span>
            <div class="text-2xl font-bold font-space text-blue-400 mt-1">{{ $stats['in_progress'] }}</div>
        </div>
        <div class="bg-[#0E1726] border border-[#1E293B] p-4 rounded-xl border-l-4 border-l-emerald-500">
            <span class="text-xs text-emerald-400 uppercase font-space">Selesai</span>
            <div class="text-2xl font-bold font-space text-emerald-400 mt-1">{{ $stats['resolved'] }}</div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-[#0E1726] border border-[#1E293B] p-4 rounded-xl">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor tiket, nama klien, perusahaan, WhatsApp..." class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">
            </div>
            <div>
                <select name="status" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs outline-none">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-[#1E293B] hover:bg-[#334155] text-white px-4 py-2 rounded-lg text-xs font-semibold w-full">Filter</button>
                @if(request()->hasAny(['q', 'status', 'priority']))
                    <a href="{{ route('admin.tickets.index') }}" class="bg-red-900/40 hover:bg-red-900/60 text-red-300 px-3 py-2 rounded-lg text-xs flex items-center justify-center">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Tickets -->
    <div class="bg-[#0E1726] border border-[#1E293B] rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-body">
                <thead>
                    <tr class="bg-[#070D18] text-[#94A3B8] font-space uppercase text-[11px] border-b border-[#1E293B]">
                        <th class="py-3.5 px-4 font-semibold">No. Tiket</th>
                        <th class="py-3.5 px-4 font-semibold">Klien / Kontak</th>
                        <th class="py-3.5 px-4 font-semibold">Layanan &amp; Wilayah</th>
                        <th class="py-3.5 px-4 font-semibold">Subjek</th>
                        <th class="py-3.5 px-4 font-semibold">Status</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi WhatsApp &amp; Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1E293B]">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-[#161F2E]/60 transition">
                            <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-[#38BDF8] hover:underline">
                                    {{ $ticket->ticket_number }}
                                </a>
                                <div class="text-[10px] text-[#64748B] font-normal">{{ $ticket->created_at->format('d M Y H:i') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-white">{{ $ticket->name }}</div>
                                @if($ticket->company)
                                    <div class="text-[11px] text-[#94A3B8]">{{ $ticket->company }}</div>
                                @endif
                                <div class="text-[11px] text-[#10B981] font-mono mt-0.5">{{ $ticket->phone }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-block bg-[#070D18] text-[#38BDF8] px-2 py-0.5 rounded border border-[#1E293B] text-[10px] font-space uppercase">
                                    {{ $ticket->service?->name ?? ($ticket->category ? ucfirst($ticket->category) : 'Konsultasi Umum') }}
                                </span>
                                @if($ticket->city)
                                    <div class="text-[11px] text-[#94A3B8] mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-[#10B981]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                        {{ $ticket->city->name }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 max-w-xs truncate text-[#c5c6ce]">
                                {{ $ticket->subject }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($ticket->status === 'pending')
                                    <span class="px-2 py-1 bg-amber-950/60 text-amber-400 border border-amber-800/60 rounded text-[10px] font-semibold uppercase font-space">Pending</span>
                                @elseif($ticket->status === 'in_progress')
                                    <span class="px-2 py-1 bg-blue-950/60 text-blue-400 border border-blue-800/60 rounded text-[10px] font-semibold uppercase font-space">Diproses</span>
                                @elseif($ticket->status === 'resolved')
                                    <span class="px-2 py-1 bg-emerald-950/60 text-emerald-400 border border-emerald-800/60 rounded text-[10px] font-semibold uppercase font-space">Selesai</span>
                                @else
                                    <span class="px-2 py-1 bg-slate-800 text-slate-400 rounded text-[10px] font-semibold uppercase font-space">Ditutup</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Direct Redirect to WhatsApp Official -->
                                    <a href="{{ route('admin.tickets.whatsapp', $ticket->id) }}" target="_blank" class="bg-[#25D366]/20 hover:bg-[#25D366] text-[#25D366] hover:text-white px-2.5 py-1.5 rounded font-semibold font-space text-[11px] border border-[#25D366]/40 flex items-center gap-1 transition" title="Buka WhatsApp Official untuk Tiket Ini">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.062-2.115-.527-1.748-.724-2.883-2.493-2.97-2.607-.088-.114-.709-.942-.709-1.796 0-.853.447-1.274.607-1.446.16-.172.352-.215.469-.215.118 0 .235.001.338.006.109.005.255-.041.399.304.149.356.508 1.239.553 1.329.045.09.076.196.015.315-.06.12-.091.196-.18.301-.091.106-.19.237-.272.318-.09.09-.184.188-.079.369.105.18.468.772 1.004 1.249.69.614 1.272.805 1.452.895.18.09.286.076.392-.045.106-.12.454-.528.575-.708.121-.18.243-.15.406-.09.164.06 1.034.488 1.212.577.177.09.296.135.34.21.045.075.045.436-.099.841z"/></svg>
                                        WA Official
                                    </a>
                                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="bg-[#1E293B] hover:bg-[#334155] text-[#94A3B8] hover:text-white px-2 py-1.5 rounded transition text-[11px]">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin hapus tiket ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-950/40 hover:bg-red-900 text-red-400 hover:text-white px-2 py-1.5 rounded transition text-[11px]">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#94A3B8]">
                                Belum ada tiket permohonan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tickets->hasPages())
            <div class="p-4 border-t border-[#1E293B]">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
