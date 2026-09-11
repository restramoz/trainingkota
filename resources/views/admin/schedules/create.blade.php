@extends('admin.layout')

@section('title', 'Tambah Jadwal Pelatihan - Admin CMS')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.schedules.index') }}" class="text-[#94A3B8] hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-[#F1F5F9] font-space uppercase tracking-wider">Tambah Jadwal Pelatihan</h1>
    </div>

    <form action="{{ route('admin.schedules.store') }}" method="POST" class="bg-[#0B1526] border border-[#1E324E] p-6 space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Layanan Pelatihan *</label>
                <select name="service_id" class="input-k3 w-full" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Kota Pelaksanaan *</label>
                <select name="city_id" class="input-k3 w-full" required>
                    <option value="">-- Pilih Kota --</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Tanggal *</label>
                <input type="date" name="date" class="input-k3 w-full" required>
                @error('date') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Waktu Mulai *</label>
                    <input type="time" name="start_time" class="input-k3 w-full" required>
                    @error('start_time') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Waktu Selesai *</label>
                    <input type="time" name="end_time" class="input-k3 w-full" required>
                    @error('end_time') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Lokasi / Alamat Lengkap *</label>
                <input type="text" name="location" class="input-k3 w-full" placeholder="Nama Hotel/Gedung, Alamat Lengkap" required>
                @error('location') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Kuota Tersedia *</label>
                <input type="number" name="available_slots" class="input-k3 w-full" min="1" required>
                @error('available_slots') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Status *</label>
                <select name="status" class="input-k3 w-full" required>
                    <option value="open">Open (Pendaftaran Terbuka)</option>
                    <option value="closed">Closed (Pendaftaran Tutup)</option>
                    <option value="completed">Completed (Selesai)</option>
                </select>
                @error('status') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-2">Catatan Tambahan</label>
                <textarea name="notes" rows="3" class="input-k3 w-full" placeholder="Contoh: Sertifikat terbit 2 minggu setelah pelatihan..."></textarea>
                @error('notes') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-6">
            <a href="{{ route('admin.schedules.index') }}" class="btn-secondary px-6 py-2 text-xs uppercase font-space">Batal</a>
            <button type="submit" class="btn-primary px-6 py-2 text-xs uppercase font-space">Simpan Jadwal</button>
        </div>
    </form>
</div>
@endsection
