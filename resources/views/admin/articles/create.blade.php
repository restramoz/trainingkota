@extends('admin.layout')

@section('title', 'Tambah Artikel')

@section('content')
    {{-- Header ----------------------------------------------------------------- --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.articles.index') }}"
               class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg transition">
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-[#F1F5F9]">Tambah Artikel</h1>
        </div>
    </div>

    {{-- Form ------------------------------------------------------------------- --}}
    <form id="articleForm"
          method="POST"
          action="{{ route('admin.articles.store') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- -------------------- AI Generation (always visible) -------------------- --}}
        <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B] mb-6">
            <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Generate dengan AI</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Kategori -------------------------------------------------------- --}}
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Kategori</label>
                    <select id="ai_category_select"
                            class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Layanan ---------------------------------------------------------- --}}
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Layanan</label>
                    <select id="ai_service_select"
                            class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih Layanan (Opsional)</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" @if(request('service_id') == $service->id) selected @endif>
                            {{ $service->name }}</option>
                    @endforeach
                    </select>
                </div>

                {{-- Kota ------------------------------------------------------------ --}}
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Kota</label>
                    <select id="ai_city_select"
                            class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kota (Opsional)</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" @if(request('city_id') == $city->id) selected @endif>
                            {{ $city->name }}</option>
                    @endforeach
                    </select>
                </div>

                {{-- Kecamatan (opsional) -------------------------------------------- --}}
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Kecamatan (Opsional)</label>
                    <select id="ai_kecamatan_select"
                            class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Semua Kecamatan</option>
                    </select>
                </div>

                {{-- Topik / Keyword ------------------------------------------------- --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Topik / Keyword</label>
                    <input type="text"
                           id="ai_topic"
                           class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" />
                </div>

                {{-- Instruksi tambahan --------------------------------------------- --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Instruksi Tambahan (Opsional)</label>
                    <textarea id="ai_additional_instructions"
                              class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                              rows="2"></textarea>
                </div>

                {{-- Jumlah kata ----------------------------------------------------- --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Jumlah Kata</label>
                    <input type="number"
                           id="ai_word_count"
                           min="100"
                           max="2000"
                           value="500"
                           class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" />
                </div>

                {{-- Tone ------------------------------------------------------------ --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Tone</label>
                    <select id="ai_tone"
                            class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="formal">Formal</option>
                        <option value="informal">Informal</option>
                        <option value="friendly">Friendly</option>
                        <option value="professional">Professional</option>
                    </select>
                </div>
            </div>

            <button type="button"
                    id="generateAiBtn"
                    class="mt-4 w-full bg-[#0D7A5F] hover:bg-[#10B981] text-white font-bold py-2 px-4 rounded-lg">
                Generate dengan AI
            </button>
        </div>

        {{-- -------------------- Main Grid (Content + SEO) -------------------- --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Content (left) --------------------------------------------------- --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                    <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Konten Utama</h2>
                    <div class="space-y-4">

                        {{-- Judul ----------------------------------------------------- --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Judul Artikel</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   required
                                   class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                   value="{{ old('title') }}">
                        </div>

                        {{-- Isi (Quill) ----------------------------------------------- --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Isi Artikel (Rich Text)</label>
                            <textarea name="content"
                                      id="content_editor"
                                      class="hidden">{{ old('content') }}</textarea>
                            <div id="quill-editor" class="bg-[#070D18] rounded-lg"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEO Settings (right) -------------------------------------------- --}}
            <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Targeting & SEO</h2>
                <div class="space-y-4">

                    {{-- Slug ------------------------------------------------------ --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Slug (URL)</label>
                        <div class="flex gap-2">
                            <input type="text"
                                   name="slug"
                                   id="slug"
                                   class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                   value="{{ old('slug') }}">
                            <button type="button"
                                    id="generateSlug"
                                    class="bg-slate-700 hover:bg-slate-600 text-white px-3 py-1 rounded text-xs transition">
                                Auto
                            </button>
                        </div>
                    </div>

                    {{-- SEO Title ------------------------------------------------- --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">SEO Title</label>
                        <input type="text"
                               name="seo_title"
                               id="seo_title"
                               class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                               value="{{ old('seo_title') }}">
                    </div>

                    {{-- Meta Description ------------------------------------------- --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Meta Description</label>
                        <textarea name="meta_description"
                                  id="meta_description"
                                  class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none h-24"
                                  placeholder="Ringkasan artikel untuk mesin pencari...">{{ old('meta_description') }}</textarea>
                    </div>

                    {{-- Target Region & Service --------------------------------------- --}}
                    <div class="pt-4 border-t border-[#1E293B] space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Kategori</label>
                            <select name="category" id="target_category"
                                    class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Layanan (Opsional)</label>
                            <select name="service_id" id="target_service"
                                    class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Pilih Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Kota / Region</label>
                            <select name="city_id" id="target_city"
                                    class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Pilih Kota</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Kecamatan (Opsional)</label>
                            <select name="kecamatan_id" id="target_kecamatan"
                                    class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Semua Kecamatan</option>
                            </select>
                        </div>
                    </div>
            </div>
        </div>

        {{-- -------------------- Status & Submit ----------------------------- --}}
        <div class="space-y-6">

            {{-- Status ---------------------------------------------------------- --}}
            <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                <h2 class="text-lg font-semibold text-[#F1F5F9] mb-4">Status</h2>
                <select name="status"
                        class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            {{-- Save ----------------------------------------------------------- --}}
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-blue-900/20">
                Simpan Artikel
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
      rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // -------------------------------------------------------------------------
    // Quill editor
    // -------------------------------------------------------------------------
    const contentInput   = document.getElementById('content_editor');
    const editorElement  = document.getElementById('quill-editor');
    const articleForm    = document.getElementById('articleForm');

    const quill = new Quill(editorElement, {
        theme: 'snow',
        placeholder: 'Tulis artikel di sini...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ indent: '-1' }, { indent: '+1' }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    const syncContent = () => {
        contentInput.value = quill.root.innerHTML;
    };
    quill.on('text-change', syncContent);

    // -------------------------------------------------------------------------
    // Auto-slug
    // -------------------------------------------------------------------------
    const titleInput      = document.getElementById('title');
    const slugInput       = document.getElementById('slug');
    const generateSlugBtn = document.getElementById('generateSlug');

    if (generateSlugBtn) {
        generateSlugBtn.addEventListener('click', function () {
            const slug = titleInput.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\\s-]/g, '')
                .replace(/\\s+/g, '-')
                .replace(/-+/g, '-');
            slugInput.value = slug;
        });
    }

    // -------------------------------------------------------------------------
    // Hidden targeting sync (kategori, layanan, kota, kecamatan)
    // -------------------------------------------------------------------------
    const targetCategory   = document.getElementById('target_category');
    const targetService    = document.getElementById('target_service');
    const targetCity       = document.getElementById('target_city');
    const targetKecamatan  = document.getElementById('target_kecamatan');

    const syncTargeting = () => {
        targetCategory.value   = document.getElementById('ai_category_select').value;
        targetService.value    = document.getElementById('ai_service_select').value;
        targetCity.value       = document.getElementById('ai_city_select').value;
        targetKecamatan.value = document.getElementById('ai_kecamatan_select').value;
    };

    // -------------------------------------------------------------------------
    // Form submit � ensure content + targeting are stored
    // -------------------------------------------------------------------------
    if (articleForm) {
        articleForm.addEventListener('submit', function () {
            syncContent();
            // Note: targeting is now handled by actual select names in HTML
        });
    }

    // -------------------------------------------------------------------------
    // AI Generation
    // -------------------------------------------------------------------------
    async function generateAiArticle() {
        // Simple client-side validation
        const category = document.getElementById('ai_category_select').value;
        const topic    = document.getElementById('ai_topic').value.trim();

        if (!category) {
            alert('Silakan pilih Kategori terlebih dahulu.');
            return;
        }
        if (!topic) {
            alert('Silakan isi Topik / Keyword untuk menghasilkan artikel.');
            return;
        }

        const btn = document.getElementById('generateAiBtn');
        const originalText = btn ? btn.innerText : 'Generate dengan AI';
        if (btn) {
            btn.disabled = true;
            btn.innerText = 'GENERATING...';
        }

        const payload = {
            service_id: document.getElementById('ai_service_select').value   || null,
            city_id:    document.getElementById('ai_city_select').value      || null,
            kecamatan_id: document.getElementById('ai_kecamatan_select').value || null,
            category:   category,
            topic:      topic,
            // Jika user tidak mengisi keyword khusus, gunakan topik sebagai fallback
            target_keyword: document.getElementById('ai_keyword')
                               ? document.getElementById('ai_keyword').value
                               : topic,
            word_count: document.getElementById('ai_word_count').value,
            tone:       document.getElementById('ai_tone').value,
            additional_instructions: document.getElementById('ai_additional_instructions').value,
            // AI safety / role rules
            rules: JSON.stringify({
                role: 'content_writer',
                max_words: document.getElementById('ai_word_count').value,
                tone: document.getElementById('ai_tone').value,
                avoid_hallucination: true,
                context_window: 2048
            })
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

            // ---------- 1?? Jika response bukan JSON atau status error ----------
            if (!response.ok) {
                const txt = await response.text();
                alert(`AI request failed (HTTP ${response.status})\\n${txt}`);
                return;
            }

            const result = await response.json();

            // ---------- 2?? Respon sukses ----------
            if (result.success) {
                if (result.title)            document.getElementById('title').value = result.title;
                if (result.slug)             document.getElementById('slug').value = result.slug;
                if (result.seo_title)       document.getElementById('seo_title').value = result.seo_title;
                if (result.meta_description) document.getElementById('meta_description').value = result.meta_description;
                if (result.content) {
                    quill.root.innerHTML = result.content;
                    syncContent();
                }
                // Sync targeting to the main form selectors
                syncTargeting();
            } else {
                // ---------- 3?? Respon error but masih JSON ----------
                const errMsg = result.error ??
                               result.message ??
                               JSON.stringify(result);
                alert('AI Error: ' + errMsg);
            }
        } catch (e) {
            // ---------- 4?? Network / parsing error ----------
            alert('Connection failed. Silakan coba lagi.\n' + e);
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerText = originalText;
            }
        }
    }

    const generateAiBtn = document.getElementById('generateAiBtn');
    if (generateAiBtn) {
        generateAiBtn.addEventListener('click', generateAiArticle);
    }

    // -------------------------------------------------------------------------
    // Kecamatan lazy-load (untuk panel AI)
    // -------------------------------------------------------------------------
    const aiCitySelect      = document.getElementById('ai_city_select');
    const aiKecamatanSelect = document.getElementById('ai_kecamatan_select');
    const targetCitySelect  = document.getElementById('target_city');
    const targetKecSelect   = document.getElementById('target_kecamatan');

    async function loadKecamatanForAi(cityId, selectedId = null) {
        if (!aiKecamatanSelect) return;

        aiKecamatanSelect.innerHTML = '<option value="">Loading...</option>';

        if (!cityId) {
            aiKecamatanSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
            if (targetKecSelect) targetKecSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
            return;
        }

        try {
            const response = await fetch(`/admin/kecamatans/get?city_id=${encodeURIComponent(cityId)}`);
            if (!response.ok) throw new Error('Gagal mengambil kecamatan');
            const data = await response.json();

            const buildOptions = (selectedId) => {
                let html = '<option value="">Semua Kecamatan</option>';
                data.forEach(d => {
                    const selected = (selectedId && String(selectedId) === String(d.id)) ? 'selected' : '';
                    html += `<option value="${d.id}" ${selected}>${d.name}</option>`;
                });
                return html;
            };

            aiKecamatanSelect.innerHTML = buildOptions(selectedId);
            if (targetKecSelect) {
                targetKecSelect.innerHTML = buildOptions(selectedId);
            }
        } catch (error) {
            console.error(error);
            aiKecamatanSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
            if (targetKecSelect) targetKecSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
        }
    }

    if (aiCitySelect) {
        aiCitySelect.addEventListener('change', function () {
            loadKecamatanForAi(this.value);
        });

        const initCity = aiCitySelect.value;
        const initKecamatan = @json(old('kecamatan_id'));

        if (initCity) {
            loadKecamatanForAi(initCity, initKecamatan);
        }
    }

    if (targetCitySelect) {
        targetCitySelect.addEventListener('change', function () {
            loadKecamatanForAi(this.value);
        });
    }

});
</script>
@endpush

