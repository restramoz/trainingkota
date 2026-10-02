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

    {{-- Info Notice: Global Targeting --}}
    <div class="bg-blue-900/30 border border-blue-700/50 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm text-blue-200">
                <p class="font-semibold">Targeting Otomatis: Global (Semua Kota & Semua Kecamatan)</p>
                <p class="mt-1">Artikel Service akan tersedia di <strong>SELURUH KOTA</strong> dan <strong>SELURUH KECAMATAN</strong> yang ada di database.</p>
                <p class="mt-1">Admin <strong>tidak perlu memilih</strong> kota atau kecamatan satu per satu. Cukup pilih Layanan & Kategori.</p>
            </div>
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

                {{-- Topik / Keyword ------------------------------------------------- --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Topik / Keyword</label>
                    <input type="text"
                           id="ai_topic"
                           class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" />
                    <input type="hidden" id="ai_target_keyword" name="ai_target_keyword" />
                    <p class="text-xs text-slate-500 mt-1">Otomatis terisi saat memilih Layanan: "Panduan {Layanan} di {Kategori}"</p>
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
                            <label class="block text-sm font-medium text-slate-400 mb-1">Judul Artikel <span class="text-slate-500">(Opsional - Auto-generate jika kosong)</span></label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                                   value="{{ old('title') }}">
                            <p class="text-xs text-slate-500 mt-1">Kosongkan untuk auto-generate: "[Nama Layanan] — Panduan [Kategori]"</p>
                        </div>

                        {{-- Isi (Quill) ----------------------------------------------- --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Isi Artikel (Rich Text)</label>
                            <textarea name="content"
                                      id="content_editor"
                                      class="hidden">{{ old('content') }}</textarea>
                                                         <!-- Jodit editor will replace the textarea -->
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
                            <label class="block text-sm font-medium text-slate-400 mb-1">Kategori <span class="text-red-400">*</span></label>
                            <select name="category" id="target_category"
                                    class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Layanan / Service</label>
                            <select name="service_id" id="target_service"
                                    class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Pilih Layanan (Opsional)</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-1">Pilih layanan untuk auto-generate judul & targeting service-wide</p>
                        </div>

                        {{-- Global Targeting Info --}}
                        <div class="pt-2 border-t border-[#1E293B] bg-blue-900/20 border-blue-700/30 rounded-lg p-3">
                            <div class="flex items-center gap-2 text-xs text-blue-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span><strong>Target: Semua Kota & Semua Kecamatan</strong> — Field kota/kecamatan tidak ditampilkan karena otomatis global.</span>
                            </div>
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
<link rel="stylesheet" href="https://unpkg.com/jodit@4.1.16/es2021/jodit.min.css">

<script src="https://unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // -------------------------------------------------------------------------
    // Jodit editor
    // -------------------------------------------------------------------------
    const contentInput   = document.getElementById('content_editor');

    const articleForm    = document.getElementById('articleForm');

    const editor = Jodit.make(contentInput, {
        placeholder: 'Tulis artikel di sini...',
        uploader: {
            url: '{{ route('admin.upload.image') }}',
            format: 'json',
            fieldName: 'files',  // Jodit expects 'files' for multiple upload
            data: { '_token': '{{ csrf_token() }}' },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            isSuccess: (resp) => resp.success === true,
            uploader: {
    url: '{{ route('admin.upload.image') }}',
    format: 'json',
    fieldName: 'files',
    data: {
        '_token': '{{ csrf_token() }}'
    },
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
    },
    isSuccess: (resp) => resp.success === true,

    error: (resp) => {
        console.error('Upload failed:', resp);
        const msg = resp.message || resp.error || JSON.stringify(resp);
        alert('Upload gagal: ' + msg);
    }
},
            error: (resp) => {
                console.error('Upload failed:', resp);
                const msg = resp.message || resp.error || JSON.stringify(resp);
                alert('Upload gagal: ' + msg);
            }
        },
        imageDefaultWidth: 600,
        imageDefaultHeight: 400
    });

    const syncContent = () => {
        contentInput.value = editor.value;
    };
    editor.events.on('change', syncContent);

    // Apply light theme styles to Jodit editor
    function applyJoditLightTheme() {
        const container = document.querySelector('.jodit-container');
        if (!container) return;

        // Force light theme on editor container
        container.style.background = '#ffffff';
        container.style.border = '1px solid #d1d5db';
        container.style.borderRadius = '4px';

        // Toolbar
        const toolbar = container.querySelector('.jodit-toolbar');
        if (toolbar) {
            toolbar.style.background = '#f3f4f6';
            toolbar.style.borderBottom = '1px solid #d1d5db';
            toolbar.style.borderRadius = '4px 4px 0 0';
        }

        // Toolbar buttons
        const buttons = container.querySelectorAll('.jodit-toolbar-button');
        buttons.forEach(btn => {
            btn.style.color = '#1f2937';
            btn.style.background = 'transparent';
        });

        // Workplace and wysiwyg area
        const workplace = container.querySelector('.jodit-workplace');
        const wysiwyg = container.querySelector('.jodit-wysiwyg');
        if (workplace) workplace.style.background = '#ffffff';
        if (wysiwyg) {
            wysiwyg.style.background = '#ffffff';
            wysiwyg.style.color = '#1f2937';
        }

        // Iframe content (if Jodit uses iframe)
        const iframe = container.querySelector('.jodit-wysiwyg_iframe');
        if (iframe) {
            iframe.style.background = '#ffffff';
            try {
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (iframeDoc && iframeDoc.body) {
                    iframeDoc.body.style.background = '#ffffff';
                    iframeDoc.body.style.color = '#1f2937';
                }
            } catch (e) {
                // Cross-origin or not ready
            }
        }

        // Style content inside editor
        const styleContent = (root) => {
            if (!root) return;
            root.querySelectorAll('p').forEach(el => el.style.color = '#1f2937');
            root.querySelectorAll('h1, h2, h3').forEach(el => el.style.color = '#0f172a');
            root.querySelectorAll('a').forEach(el => el.style.color = '#006bb6');
            root.querySelectorAll('blockquote').forEach(el => {
                el.style.borderLeft = '3px solid #006bb6';
                el.style.background = '#f0f4f8';
                el.style.color = '#1f2937';
                el.style.padding = '8px 12px';
            });
            root.querySelectorAll('code').forEach(el => {
                if (!el.closest('pre')) {
                    el.style.background = '#f3f4f6';
                    el.style.color = '#1f2937';
                    el.style.padding = '2px 4px';
                    el.style.borderRadius = '3px';
                }
            });
            root.querySelectorAll('pre').forEach(el => {
                el.style.background = '#1f2937';
                el.style.color = '#e5e7eb';
                el.style.padding = '12px';
                el.style.borderRadius = '4px';
            });
            root.querySelectorAll('table').forEach(el => {
                el.style.borderCollapse = 'collapse';
                el.style.width = '100%';
            });
            root.querySelectorAll('th, td').forEach(el => {
                el.style.border = '1px solid #d1d5db';
                el.style.padding = '8px';
                el.style.background = '#ffffff';
                el.style.color = '#1f2937';
            });
            root.querySelectorAll('th').forEach(el => {
                el.style.background = '#f3f4f6';
                el.style.fontWeight = '600';
            });
        };

        // Style current content - disabled to avoid inline styles
        // if (wysiwyg) styleContent(wysiwyg);
        // if (iframe) {
        //     try {
        //         const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
        //         if (iframeDoc && iframeDoc.body) styleContent(iframeDoc.body);
        //     } catch (e) {}
        // }
    }

    // Apply theme after editor initializes
    setTimeout(applyJoditLightTheme, 100);
    editor.events.on('change', applyJoditLightTheme);

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
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            slugInput.value = slug;
        });
    }

    // -------------------------------------------------------------------------
    // Auto-generate Topic/Keyword from Service + Category
    // -------------------------------------------------------------------------
    function autoGenerateTopicAndKeyword() {
        const serviceSelect = document.getElementById('ai_service_select');
        const categorySelect = document.getElementById('ai_category_select');
        const topicInput = document.getElementById('ai_topic');
        const keywordInput = document.getElementById('ai_target_keyword');

        if (!serviceSelect || !categorySelect || !topicInput || !keywordInput) return;

        const serviceId = serviceSelect.value;
        const category = categorySelect.value;

        if (serviceId && category) {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const serviceName = selectedOption.textContent.trim();
            const categoryLabel = category.charAt(0).toUpperCase() + category.slice(1);

            // Smart generation: avoid duplicating "Panduan" or category name
            let generatedTopic;
            const serviceNameLower = serviceName.toLowerCase();
            const categoryLabelLower = categoryLabel.toLowerCase();

            // Check if service name already contains "panduan" or category name
            const hasPanduan = serviceNameLower.includes('panduan');
            const hasCategory = serviceNameLower.includes(categoryLabelLower);

            if (hasPanduan && hasCategory) {
                // Service name already has both: "Panduan Authorizer Gas Tester di Pelatihan"
                generatedTopic = serviceName;
            } else if (hasPanduan) {
                // Service name has "Panduan" but not category: "Panduan Authorizer Gas Tester di Pelatihan"
                generatedTopic = `${serviceName} di ${categoryLabel}`;
            } else if (hasCategory) {
                // Service name has category but not "Panduan": "Panduan Authorizer Gas Tester Pelatihan"
                generatedTopic = `Panduan ${serviceName}`;
            } else {
                // Neither: "Panduan Authorizer Gas Tester di Pelatihan"
                generatedTopic = `Panduan ${serviceName} di ${categoryLabel}`;
            }

            topicInput.value = generatedTopic;
            keywordInput.value = generatedTopic;
        } else if (!serviceId) {
            topicInput.value = '';
            keywordInput.value = '';
        }
    }

    // Attach event listeners for auto-generation
    const aiServiceSelect = document.getElementById('ai_service_select');
    const aiCategorySelect = document.getElementById('ai_category_select');
    if (aiServiceSelect) {
        aiServiceSelect.addEventListener('change', autoGenerateTopicAndKeyword);
    }
    if (aiCategorySelect) {
        aiCategorySelect.addEventListener('change', autoGenerateTopicAndKeyword);
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
            // city_id and kecamatan_id removed - now global by default
            category:   category,
            topic:      topic,
            target_keyword: document.getElementById('ai_target_keyword')
                               ? document.getElementById('ai_target_keyword').value
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
                alert(`AI request failed (HTTP ${response.status})\n${txt}`);
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
                    editor.value = result.content;
                    syncContent();
                }
                // Sync targeting to the main form selectors
                document.getElementById('target_category').value = category;
                document.getElementById('target_service').value = document.getElementById('ai_service_select').value || '';
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
    // Form submit - ensure content is synced
    // -------------------------------------------------------------------------
    if (articleForm) {
        articleForm.addEventListener('submit', function () {
            syncContent();
        });
    }

});
</script>
@endpush