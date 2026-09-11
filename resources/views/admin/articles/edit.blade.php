@extends('admin.layout')

@section('title', 'Edit Artikel')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a
                href="{{ route('admin.articles.index') }}"
                class="bg-[#0F2038] hover:bg-[#142338] border border-[#1E324E] text-[#F1F5F9] px-4 py-2 text-xs font-space uppercase transition"
            >
                Kembali
            </a>

            <div>
                <h1 class="text-2xl font-bold text-[#F1F5F9]">
                    Edit Artikel
                </h1>
                <p class="text-xs text-[#64748B] mt-1">
                    Perbarui konten, SEO, targeting, dan status publikasi.
                </p>
            </div>
        </div>

        <form
            action="{{ route('admin.articles.toggle-status', $article->id) }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="px-4 py-2 text-xs font-space font-bold uppercase transition
                {{ $article->status === 'published'
                    ? 'bg-[#7F1D1D] hover:bg-[#991B1B] text-white'
                    : 'bg-[#0D7A5F] hover:bg-[#10B981] text-white' }}"
            >
                {{ $article->status === 'published' ? 'Unpublish' : 'Publish Now' }}
            </button>
        </form>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-[#2A1010] border border-[#7F1D1D] p-4">
            <div class="text-xs font-space font-bold uppercase text-[#FCA5A5] mb-2">
                Validation Error
            </div>

            <ul class="space-y-1 text-xs text-[#FCA5A5]">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MAIN FORM -->
    <form
        action="{{ route('admin.articles.update', $article->id) }}"
        method="POST"
        id="articleForm"
        class="space-y-6"
    >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- LEFT / MAIN CONTENT -->
            <div class="xl:col-span-2 space-y-6">

                <!-- CONTENT -->
                <div class="bg-[#0B1526] border border-[#1E324E]">
                    <div class="px-5 py-4 border-b border-[#1E324E] bg-[#0F2038]">
                        <h2 class="font-space text-sm font-bold uppercase text-[#F1F5F9]">
                            Konten Utama
                        </h2>
                    </div>

                    <div class="p-5 space-y-5">

                        <!-- TITLE -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Judul Artikel *
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                required
                                value="{{ old('title', $article->title) }}"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                        </div>
                        
                        <!-- AI Regeneration Button -->
                        <div class="mt-2">
                        <button type="button" id="generateAiBtnEdit" onclick="generateAiArticleEdit()" class="bg-[#0D7A5F] hover:bg-[#10B981] text-white px-3 py-1 rounded text-xs transition">
                            Generate / Regenerate with AI
                        </button>
                        </div>

                        <!-- CONTENT -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Isi Artikel *
                            </label>

                         <textarea
    name="content"
    id="content_editor"
    class="hidden"
>{{ old('content', $article->content) }}</textarea>

<div
    id="quill-editor"
    class="bg-[#070D18] border border-[#1E324E] text-[#F1F5F9]"
>
    {!! old('content', $article->content) !!}
</div>
                        </div>

                    </div>
                </div>

                <!-- SEO -->
                <div class="bg-[#0B1526] border border-[#1E324E]">

                    <div class="px-5 py-4 border-b border-[#1E324E] bg-[#0F2038]">
                        <h2 class="font-space text-sm font-bold uppercase text-[#F1F5F9]">
                            Pengaturan SEO
                        </h2>
                    </div>

                    <div class="p-5 space-y-5">

                        <!-- SLUG -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Slug URL
                            </label>

                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    name="slug"
                                    id="slug"
                                    value="{{ old('slug', $article->slug) }}"
                                    class="flex-1 h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                                >

                                <button
                                    type="button"
                                    id="generateSlug"
                                    class="px-4 h-11 bg-[#0F2038] hover:bg-[#142338] border border-[#1E324E] text-[#F1F5F9] text-xs font-space uppercase transition"
                                >
                                    Auto
                                </button>
                            </div>
                        </div>

                        <!-- SEO TITLE -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                SEO Title
                            </label>

                            <input
                                type="text"
                                name="seo_title"
                                value="{{ old('seo_title', $article->seo_title) }}"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                        </div>

                        <!-- META DESCRIPTION -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Meta Description
                            </label>

                            <textarea
                                name="meta_description"
                                rows="4"
                                class="w-full bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 py-3 text-sm outline-none focus:border-[#0D7A5F] resize-y"
                            >{{ old('meta_description', $article->meta_description) }}</textarea>
                        </div>

                        <!-- FOCUS KEYWORDS -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Focus Keywords
                            </label>

                            <input
                                type="text"
                                name="focus_keywords"
                                value="{{ old('focus_keywords', $article->focus_keywords) }}"
                                placeholder="k3, pelatihan k3, ahli k3 malang"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                        <!-- CATEGORY -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Kategori *
                            </label>

                            <select
                                name="category"
                                id="category"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                                <option value="">Pilih Kategori</option>
                                <option value="pelatihan" {{ old('category', $article->category) == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="kajian" {{ old('category', $article->category) == 'kajian' ? 'selected' : '' }}>Kajian</option>
                                <option value="jasa" {{ old('category', $article->category) == 'jasa' ? 'selected' : '' }}>Jasa</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT / SIDEBAR -->
            <div class="space-y-6">

                <!-- TARGETING -->
                <div class="bg-[#0B1526] border border-[#1E324E]">

                    <div class="px-5 py-4 border-b border-[#1E324E] bg-[#0F2038]">
                        <h2 class="font-space text-sm font-bold uppercase text-[#F1F5F9]">
                            Targeting
                        </h2>
                    </div>

                    <div class="p-5 space-y-5">

                        <!-- CATEGORY -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Kategori *
                            </label>

                            <select
    name="kecamatan_id"
    id="kecamatan_id"
    class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
>
    <option value="">Semua Kecamatan</option>
</select>
                        </div>

                        <!-- SERVICE -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Layanan
                            </label>

                            <select
                                name="service_id"
                                id="service_id"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                                <option value="">Semua Layanan</option>

                                @foreach($services as $service)
                                    <option
                                        value="{{ $service->id }}"
                                        {{ old('service_id', $article->service_id) == $service->id ? 'selected' : '' }}
                                    >
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- CITY -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Kota
                            </label>

                            <select
                                name="city_id"
                                id="city_id"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                                <option value="">Semua Kota</option>

                                @foreach($cities as $city)
                                    <option
                                        value="{{ $city->id }}"
                                        {{ old('city_id', $article->city_id) == $city->id ? 'selected' : '' }}
                                    >
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- KECAMATAN -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Kecamatan
                            </label>

                            <select
                                name="kecamatan_id"
                                id="kecamatan_id"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                                <option value="">Semua Kecamatan</option>

                                    
                            </select>
                        </div>

                    </div>
                </div>

                <!-- STATUS -->
                <div class="bg-[#0B1526] border border-[#1E324E]">

                    <div class="px-5 py-4 border-b border-[#1E324E] bg-[#0F2038]">
                        <h2 class="font-space text-sm font-bold uppercase text-[#F1F5F9]">
                            Status Publikasi
                        </h2>
                    </div>

                    <div class="p-5">

                        <select
                            name="status"
                            class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                        >
                            <option
                                value="draft"
                                {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}
                            >
                                Draft
                            </option>

                            <option
                                value="published"
                                {{ old('status', $article->status) === 'published' ? 'selected' : '' }}
                            >
                                Published
                            </option>
                        </select>

                    </div>
                </div>

                <!-- SAVE -->
                <button
                    type="submit"
                    class="w-full h-12 bg-[#0D7A5F] hover:bg-[#10B981] text-white font-space font-bold text-xs uppercase tracking-wider transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>

</div>
@endsection


@push('scripts')

<link
    href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
    rel="stylesheet"
>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================
       QUILL EDITOR
    ========================================================== */

    const contentInput = document.getElementById('content_editor');
    const editorElement = document.getElementById('quill-editor');
    const articleForm = document.getElementById('articleForm');

    const quill = new Quill(editorElement, {
        theme: 'snow',

        placeholder: 'Tulis artikel di sini...',

        modules: {
    toolbar: [
        [
            {
                header: [1, 2, 3, false]
            }
        ],

        ['bold', 'italic', 'underline', 'strike'],

        [
            {
                align: ''
            },
            {
                align: 'center'
            },
            {
                align: 'right'
            },
            {
                align: 'justify'
            }
        ],

        [
            {
                list: 'ordered'
            },
            {
                list: 'bullet'
            }
        ],

        [
            {
                indent: '-1'
            },
            {
                indent: '+1'
            }
        ],

        ['blockquote', 'code-block'],

        ['link', 'image'],

        ['clean']
    ]
}
    });


    /* ==========================================================
       SYNC QUILL -> TEXTAREA
    ========================================================== */

    function syncContent() {
        if (contentInput) {
            contentInput.value = quill.root.innerHTML;
        }
    }


    quill.on('text-change', function () {
        syncContent();
    });


    /* ==========================================================
       FORM SUBMIT
    ========================================================== */

    if (articleForm) {
        articleForm.addEventListener('submit', function () {
            syncContent();
        });
    }


    /* ==========================================================
       AUTO SLUG
    ========================================================== */

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const generateSlugBtn = document.getElementById('generateSlug');

    function generateSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

    if (generateSlugBtn && titleInput && slugInput) {
        generateSlugBtn.addEventListener('click', function () {
            slugInput.value = generateSlug(titleInput.value);
        });
    }

    // ----------------------------------------------------------
    // AI Regeneration Function (Edit)
    // ----------------------------------------------------------
    async function generateAiArticleEdit() {
        const btn = document.getElementById('generateAiBtnEdit');
        const originalText = btn ? btn.innerText : 'Generate';
        if (btn) { btn.disabled = true; btn.innerText = 'GENERATING...'; }

        const payload = {
            // Assuming we reuse same endpoint; include existing fields if needed
            service_id: document.getElementById('service_id')?.value || null,
            city_id: document.getElementById('city_id')?.value || null,
            kecamatan_id: document.getElementById('kecamatan_id')?.value || null,
            category: document.getElementById('category')?.value || null,
            // For edit, we may use current title as topic
            topic: document.getElementById('title')?.value,
            target_keyword: document.getElementById('seo_title')?.value || '',
            word_count: '',
            tone: '',
            additional_instructions: ''
        };
        try {
            const response = await fetch('{{ route('admin.articles.ai-generate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const result = await response.json();
            if (result.success) {
                if (result.title) titleInput.value = result.title;
                if (result.slug) slugInput.value = result.slug;
                if (result.seo_title) document.getElementById('seo_title').value = result.seo_title;
                if (result.meta_description) document.getElementById('meta_description').value = result.meta_description;
                if (result.content) { quill.root.innerHTML = result.content; syncContent(); }
            } else {
                alert('AI Error: ' + result.error);
            }
        } catch (e) {
            alert('Connection failed. Please try again.');
        } finally {
            if (btn) { btn.disabled = false; btn.innerText = originalText; }
        }
    }


    /* ==========================================================
       KECAMATAN LOADER
    ========================================================== */

    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('kecamatan_id');

    if (citySelect && districtSelect) {

            citySelect.addEventListener('change', function () {

            const cityId = this.value;

            districtSelect.innerHTML =
                '<option value="">Loading...</option>';

            if (!cityId) {
                districtSelect.innerHTML =
                    '<option value="">Semua Kecamatan</option>';
                return;
            }

            fetch(`/admin/kecamatans/get?city_id=${encodeURIComponent(cityId)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil kecamatan');
                    }

                    return response.json();
                })
                .then(data => {

                    districtSelect.innerHTML =
                        '<option value="">Semua Kecamatan</option>';

                    data.forEach(district => {

                        const option = document.createElement('option');

                        option.value = district.id;
                        option.textContent = district.name;

                        districtSelect.appendChild(option);
                    });

                })
                .catch(error => {

                    console.error(error);

                    districtSelect.innerHTML =
                        '<option value="">Gagal memuat kecamatan</option>';
                });

        });
    }

});
</script>

@endpush

