@extends('admin.layout')

@section('title', 'Tambah Tiket Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.tickets.index') }}" class="text-xs text-[#94A3B8] hover:text-white flex items-center gap-1 font-space mb-2">
                &larr; Kembali ke Daftar Tiket
            </a>
            <h1 class="text-2xl font-bold font-space text-[#F1F5F9]">Buat Tiket Konsultasi Baru</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tickets.store') }}" class="bg-[#0E1726] border border-[#1E293B] p-6 rounded-xl space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nama Pemohon / Klien *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">
            </div>

            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nomor WhatsApp *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08123456789" required class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">
            </div>

            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nama Perusahaan / PT</label>
                <input type="text" name="company" value="{{ old('company') }}" placeholder="PT Mitra Sejahtera" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">
            </div>

            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="klien@perusahaan.com" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">
            </div>

            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Kategori Layanan</label>
                <select name="category" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs outline-none">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="pelatihan" {{ old('category') === 'pelatihan' ? 'selected' : '' }}>Pelatihan K3</option>
                    <option value="kajian" {{ old('category') === 'kajian' ? 'selected' : '' }}>Kajian Teknis</option>
                    <option value="jasa" {{ old('category') === 'jasa' ? 'selected' : '' }}>Jasa SLF &amp; Izin</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Pilih Layanan Spesifik</label>
                <select name="service_id" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs outline-none">
                    <option value="">-- Bebas / Pilih Layanan --</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" {{ old('service_id') == $s->id ? 'selected' : '' }}>
                            [{{ ucfirst($s->category) }}] {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Kota / Wilayah Pelaksanaan</label>
                <select name="city_id" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs outline-none">
                    <option value="">-- Pilih Kota / Wilayah --</option>
                    @foreach($cities as $c)
                        <option value="{{ $c->id }}" {{ old('city_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->province }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Prioritas</label>
                <select name="priority" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs outline-none">
                    <option value="low">Rendah</option>
                    <option value="medium" selected>Normal / Sedang</option>
                    <option value="high">Tinggi</option>
                    <option value="urgent">Urgent / Mendesak</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Subjek Permohonan *</label>
            <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Permohonan In-house Training Ahli K3 Umum untuk 10 Personel" required class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">
        </div>

        <div>
            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Pesan / Kebutuhan Detail *</label>
            <textarea name="message" rows="4" required placeholder="Jelaskan kebutuhan, perkiraan tanggal pelaksanaan, dan jumlah peserta..." class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">{{ old('message') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Catatan Internal Admin</label>
            <textarea name="notes" rows="2" placeholder="Catatan khusus tim CS / Sales..." class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-[#10B981] outline-none">{{ old('notes') }}</textarea>
        </div>

        <input type="hidden" name="status" value="pending">

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#1E293B]">
            <a href="{{ route('admin.tickets.index') }}" class="bg-[#1E293B] hover:bg-[#334155] text-white px-4 py-2 rounded-lg text-xs font-semibold">
                Batal
            </a>
            <button type="submit" class="bg-[#0D7A5F] hover:bg-[#10B981] text-white px-6 py-2 rounded-lg text-xs font-semibold font-space">
                Simpan Tiket
            </button>
        </div>
    </form>
</div>
@endsection
