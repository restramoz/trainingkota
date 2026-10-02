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
                    <li>� {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Info Notice: Global Targeting --}}
    <div class="bg-blue-900/30 border border-blue-700/50 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm text-blue-200">
                <p class="font-semibold">Targeting: Global (Semua Kota & Semua Kecamatan)</p>
                <p class="mt-1">Artikel ini tersedia di <strong>SELURUH KOTA</strong> dan <strong>SELURUH KECAMATAN</strong>.</p>
                <p class="mt-1">Field kota/kecamatan tidak ditampilkan karena targeting otomatis global.</p>
            </div>
        </div>
    </div>

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
                                Judul Artikel <span class="text-slate-500">(Opsional - Auto-generate jika kosong)</span>
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title', $article->title) }}"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                            <p class="text-xs text-slate-500 mt-1">Kosongkan untuk auto-generate: "[Nama Layanan] — Panduan [Kategori]"</p>
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

        <!-- Jodit editor will replace the textarea -->
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
                        </div>
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

                        <!-- SERVICE -->
                        <div>
                            <label class="block text-[10px] font-space uppercase tracking-wider text-[#94A3B8] mb-2">
                                Layanan / Service
                            </label>

                            <select
                                name="service_id"
                                id="service_id"
                                class="w-full h-11 bg-[#070D18] border border-[#1E324E] text-[#F1F5F9] px-3 text-sm outline-none focus:border-[#0D7A5F]"
                            >
                                <option value="">Semua Layanan (Umum)</option>

                                @foreach($services as $service)
                                    <option
                                        value="{{ $service->id }}"
                                        {{ old('service_id', $article->service_id) == $service->id ? 'selected' : '' }}
                                    >
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-1">Pilih layanan untuk targeting service-wide & auto-generate judul</p>
                        </div>

                        <!-- AI Topic/Keyword Auto-generation (Hidden Fields) -->
                        <input type="hidden" id="ai_target_keyword_edit" name="ai_target_keyword_edit" />
                        <p class="text-xs text-slate-500 mt-1">Topik/Keyword otomatis terisi: "Panduan {Layanan} di {Kategori}"</p>

                        {{-- Global Targeting Info --}}
                        <div class="pt-2 border-t border-[#1E324E] bg-blue-900/20 border-blue-700/30 rounded-lg p-3">
                            <div class="flex items-center gap-2 text-xs text-blue-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span><strong>Target: Semua Kota & Semua Kecamatan</strong> — Field kota/kecamatan tidak ditampilkan karena otomatis global.</span>
                            </div>
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

<link rel="stylesheet" href="https://unpkg.com/jodit@4.1.16/es2021/jodit.min.css">

<script src="https://unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================================
       JODIT EDITOR
    ========================================================== */

    const contentInput = document.getElementById('content_editor');

    const articleForm = document.getElementById('articleForm');

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
            getResponseData: (resp) => {
                // Handle new response format: {success: true, data: {files: [...], newfilename: "...", isImages: [...]}}
                if (resp.data && resp.data.files && resp.data.files.length > 0) {
                    return { url: resp.data.files[0] };
                }
                // Fallback for old format
                if (resp.url) {
                    return { url: resp.url };
                }
                return { url: '' };
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


    /* ==========================================================
       SYNC JODIT -> TEXTAREA
    ========================================================== */

    function syncContent() {
        if (contentInput) {
            contentInput.value = editor.value;
        }
    }


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
    // Auto-generate Topic/Keyword from Service + Category (Edit)
    // ----------------------------------------------------------
    function autoGenerateTopicAndKeywordEdit() {
        const serviceSelect = document.getElementById('service_id');
        const categorySelect = document.getElementById('category');
        const keywordInput = document.getElementById('ai_target_keyword_edit');

        if (!serviceSelect || !categorySelect || !keywordInput) return;

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

            keywordInput.value = generatedTopic;
        } else if (!serviceId) {
            keywordInput.value = '';
        }
    }

    // Attach event listeners for auto-generation (Edit)
    const editServiceSelect = document.getElementById('service_id');
    const editCategorySelect = document.getElementById('category');
    if (editServiceSelect) {
        editServiceSelect.addEventListener('change', autoGenerateTopicAndKeywordEdit);
    }
    if (editCategorySelect) {
        editCategorySelect.addEventListener('change', autoGenerateTopicAndKeywordEdit);
    }

    // Trigger on page load if service is pre-selected
    if (editServiceSelect && editServiceSelect.value) {
        autoGenerateTopicAndKeywordEdit();
    }

    // ----------------------------------------------------------
    // AI Regeneration Function (Edit)
    // ----------------------------------------------------------
    async function generateAiArticleEdit() {
        const btn = document.getElementById('generateAiBtnEdit');
        const originalText = btn ? btn.innerText : 'Generate';
        if (btn) { btn.disabled = true; btn.innerText = 'GENERATING...'; }

        const payload = {
            service_id: document.getElementById('service_id')?.value || null,
            category: document.getElementById('category')?.value || null,
            topic: document.getElementById('title')?.value,
            target_keyword: document.getElementById('ai_target_keyword_edit')?.value || document.getElementById('seo_title')?.value || '',
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
                if (result.content) { editor.value = result.content; syncContent(); }
            } else {
                alert('AI Error: ' + result.error);
            }
        } catch (e) {
            alert('Connection failed. Please try again.');
        } finally {
            if (btn) { btn.disabled = false; btn.innerText = originalText; }
        }
    }

});
</script>

@endpush