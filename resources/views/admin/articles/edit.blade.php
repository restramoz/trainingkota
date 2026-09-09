@extends('admin.layout')

@section('title', 'Edit Artikel')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.articles.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg transition">
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-[#F1F5F9]">Edit Artikel</h1>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('admin.articles.toggle-status', $article->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    {{ $article->status === 'published' ? 'Unpublish' : 'Publish Now' }}
                </button>
            </form>
        </div>
    </div>

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" id="articleForm" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                    <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Konten Utama</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Judul Artikel</label>
                            <input type="text" name="title" id="title" required 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('title', $article->title) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Isi Artikel (Rich Text)</label>
                            <textarea name="content" id="content_editor" class="hidden">{{ old('content', $article->content) }}</textarea>
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
                                    value="{{ old('slug', $article->slug) }}">
                                <button type="button" id="generateSlug" class="bg-slate-700 hover:bg-slate-600 text-white px-3 py-1 rounded text-xs transition">Auto</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">SEO Title</label>
                            <input type="text" name="seo_title" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('seo_title', $article->seo_title) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Meta Description</label>
                            <textarea name="meta_description" rows="3" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('meta_description', $article->meta_description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Focus Keywords</label>
                            <input type="text" name="focus_keywords" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('focus_keywords', $article->focus_keywords) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Excerpt</label>
                            <textarea name="excerpt" rows="2" 
                                class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('excerpt', $article->excerpt) }}</textarea>
                        </div>
                    </div>
                </div>

                </div>
                <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                    <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Status Publikasi</h2>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Status</label>
                        <select name="status" 
                            class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg">Simpan Perubahan</button>
            </div>




        </div>
    </form>
</div>


    <div class="lg:col-span-1 space-y-6">
        <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
            <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Target Lokasi</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Provinsi</label>
                    <select name="province_id" id="province_id" 
                        class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Semua Provinsi</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province_id', $article->province_id) == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Kota/Kabupaten</label>
                    <select name="city_id" id="city_id" 
                        class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $article->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Kecamatan</label>
                    <select name="district_id" id="district_id" 
                        class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Semua Kecamatan</option>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/6.8/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content_editor',
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | removeformat | help',
        skin: 'oxide-dark',
        content_css: 'dark',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });

    document.getElementById('generateSlug').addEventListener('click', function() {
        const title = document.getElementById('title').value;
        const slug = title.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('slug').value = slug;
    });

    // Dynamic Location Loading
    document.getElementById('city_id').addEventListener('change', function() {
        const cityId = this.value;
        const districtSelect = document.getElementById('district_id');
        
        districtSelect.innerHTML = '<option value=\"\">Loading...</option>';
        
        if (!cityId) {
            districtSelect.innerHTML = '<option value=\"\">Semua Kecamatan</option>';
            return;
        }

        fetch(`/admin/kecamatans/get?city_id=${cityId}`)
            .then(res => res.json())
            .then(data => {
                districtSelect.innerHTML = '<option value=\"\">Semua Kecamatan</option>';
                data.forEach(district => {
                    districtSelect.innerHTML += `<option value=\"${district.id}\">${district.name}</option>`;
                });
            });
    });
    // Dynamic Location Loading
    document.getElementById('province_id').addEventListener('change', function() {
        const provinceId = this.value;
        const citySelect = document.getElementById('city_id');
        const districtSelect = document.getElementById('district_id');
        
        citySelect.innerHTML = '<option value="">Loading...</option>';
        districtSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
        
        if (!provinceId) {
            citySelect.innerHTML = '<option value="">Semua Kota</option>';
            return;
        }

        fetch(`/admin/locations/cities?province_id=${provinceId}`)
            .then(res => res.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">Semua Kota</option>';
                data.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            });
    });

    document.getElementById('city_id').addEventListener('change', function() {
        const cityId = this.value;
        const districtSelect = document.getElementById('district_id');
        
        districtSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (!cityId) {
            districtSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
            return;
        }

        fetch(`/admin/locations/districts?city_id=${cityId}`)
            .then(res => res.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
                data.forEach(district => {
                    districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                });
            });
    });
</script>
@endpush

@stop

                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id', $article->district_id) == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
            <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Kategori Layanan</h2>
            <div class="space-y-2">
                @foreach(['pelatihan', 'kajian', 'jasa'] as $cat)
                <label class="flex items-center gap-3 p-2 hover:bg-[#1E293B] rounded-lg cursor-pointer transition">
                    <input type="checkbox" name="categories[]" value="{{ $cat }}" 
                        {{ in_array($cat, old('categories', $article->categories ?? [])) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded">
                    <span class="text-slate-300 capitalize">{{ $cat }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

