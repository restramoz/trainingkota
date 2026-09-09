@extends('admin.layout')

@section('title', 'Tambah Artikel')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.articles.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg transition">
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-[#F1F5F9]">Tambah Artikel</h1>
        </div>
    </div>

    <form action="{{ route('admin.articles.store') }}" method="POST" id="articleForm" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                    <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Konten Utama</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Judul Artikel</label>
                            <input type="text" name="title" id="title" required 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('title') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Isi Artikel (Rich Text)</label>
                            <textarea name="content" id="content_editor" class="hidden">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                    <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Pengaturan SEO</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Slug (URL)</label>
                            <div class="flex gap-2">
                                <input type="text" name="slug" id="slug" 
                                    class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                    value="{{ old('slug') }}">
                                <button type="button" id="generateSlug" class="bg-slate-700 hover:bg-slate-600 text-white px-3 py-1 rounded text-xs transition">Auto</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">SEO Title</label>
                            <input type="text" name="seo_title" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('seo_title') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Meta Description</label>
                            <textarea name="meta_description" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none h-24"
                                placeholder="Ringkasan artikel untuk mesin pencari...">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                    <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Targeting</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Kategori</label>
                            <select name="category" required
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Layanan</label>
                            <select name="service_id" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Semua Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Kota</label>
                            <select name="city_id" id="city_id" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Semua Kota</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Semua Kecamatan</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                    <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Status</h2>
                    <select name="status" 
                        class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-blue-900/20">
                    Simpan Artikel
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const generateSlugBtn = document.getElementById('generateSlug');

        function generateSlug(text) {
            return text.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-')
                .trim();
        }

        generateSlugBtn.addEventListener('click', function() {
            slugInput.value = generateSlug(titleInput.value);
        });

        const citySelect = document.getElementById('city_id');
        const districtSelect = document.getElementById('kecamatan_id');

        citySelect.addEventListener('change', function() {
            const cityId = this.value;
            
            districtSelect.innerHTML = '<option value="">Loading...</option>';
            
            if (!cityId) {
                districtSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
                return;
            }

            fetch(`/admin/kecamatans/get?city_id=${cityId}`)
                .then(res => res.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                })
                .catch(err => {
                    console.error('Error loading districts:', err);
                    districtSelect.innerHTML = '<option value="">Error loading data</option>';
                });
        });
    });
</script>
@endpush
@stop
