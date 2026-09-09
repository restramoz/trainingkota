@extends('layouts.app')

@section('title', 'Preview AI Generated Article - TrainingKota')

@section('content')
<div class="min-h-screen bg-[#070D18] text-[#F1F5F9] font-sans antialiased pb-12">
    <div class="max-w-5xl mx-auto px-4 lg:px-8 py-6 space-y-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between bg-[#0B1526] border border-[#1E324E] p-4 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="bg-[#0D7A5F]/20 p-2 text-[#10B981] border border-[#0D7A5F] rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h1 class="font-space font-bold text-sm uppercase tracking-wider">AI Content Review</h1>
                    <p class="text-[10px] text-[#64748B]">Review and edit AI-generated content before saving.</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.dashboard', ['tab' => 'articles']) }}" class="px-4 py-2 text-xs font-space uppercase text-[#94A3B8] hover:text-white transition">Cancel</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- LEFT: Editor & Metadata -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0B1526] border border-[#1E324E] rounded-lg overflow-hidden">
                    <div class="px-4 py-3 border-b border-[#1E324E] bg-[#0F2038] flex items-center justify-between">
                        <span class="font-space text-xs font-bold uppercase tracking-wider text-[#CBD5E1]">Content Editor</span>
                        <span class="text-[10px] text-[#64748B]">HTML Mode</span>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block font-space text-[10px] uppercase text-[#64748B] mb-1">Article Title</label>
                            <input type="text" id="preview_title" value="{{ $data['title'] }}" class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-sm rounded focus:border-[#0D7A5F] outline-none">
                        </div>
                        <div>
                            <label class="block font-space text-[10px] uppercase text-[#64748B] mb-1">Main Content (HTML)</label>
                            <textarea id="preview_content" rows="20" class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-sm rounded font-mono focus:border-[#0D7A5F] outline-none">{{ $data['content'] }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Suggested FAQs -->
                <div class="bg-[#0B1526] border border-[#1E324E] rounded-lg overflow-hidden">
                    <div class="px-4 py-3 border-b border-[#1E324E] bg-[#0F2038] flex items-center justify-between">
                        <span class="font-space text-xs font-bold uppercase tracking-wider text-[#CBD5E1]">Suggested FAQs</span>
                    </div>
                    <div class="p-5 space-y-3">
                        @if(!empty($data['faq_items']))
                        @foreach($data['faq_items'] as $index => $faq)
                        <div class="p-3 bg-[#070D18] border border-[#1E324E] rounded-lg space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold text-[#64748B]">Q{{ $index + 1 }}</span>
                                <input type="text" class="bg-transparent border-none text-[#F1F5F9] text-xs w-full focus:ring-0 p-0" value="{{ $faq['q'] ?? '' }}">
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold text-[#64748B]">A</span>
                                <textarea rows="2" class="bg-transparent border-none text-[#94A3B8] text-xs w-full focus:ring-0 p-0">{{ $faq['a'] ?? '' }}</textarea>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="text-xs text-[#64748B] text-center py-4">No suggested FAQs generated.</p>
                        @endif
                    </div>
                </div>

                <!-- Suggested Internal Links -->
                <div class="bg-[#0B1526] border border-[#1E324E] rounded-lg overflow-hidden mt-4">
                    <div class="px-4 py-3 border-b border-[#1E324E] bg-[#0F2038] flex items-center justify-between">
                        <span class="font-space text-xs font-bold uppercase tracking-wider text-[#CBD5E1]">Suggested Internal Links</span>
                        <button type="button" onclick="addInternalLink()" class="text-xs text-[#94A3B8] hover:text-[#F1F5F9]">+ Add Link</button>
                    </div>
                    <div class="p-5 space-y-3" id="internal_links_container">
                        @if(!empty($data['suggested_internal_links']))
                        @foreach($data['suggested_internal_links'] as $idx => $link)
                        <div class="flex items-center gap-2 internal-link-row">
                            <input type="text" class="bg-transparent border border-[#1E324E] text-[#F1F5F9] text-xs w-1/2 p-1 rounded focus:border-[#0D7A5F]" value="{{ $link['text'] ?? '' }}" placeholder="Link Text">
                            <input type="text" class="bg-transparent border border-[#1E324E] text-[#F1F5F9] text-xs w-1/2 p-1 rounded focus:border-[#0D7A5F]" value="{{ $link['url'] ?? '' }}" placeholder="URL">
                            <button type="button" onclick="removeInternalLink(this)" class="text-xs text-[#94A3B8] hover:text-[#F1F5F9]">✕</button>
                        </div>
                        @endforeach
                        @else
                        <p class="text-xs text-[#64748B] text-center py-4">No suggested internal links.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RIGHT: SEO & Actions -->
            <div class="space-y-6">
                <div class="bg-[#0B1526] border border-[#1E324E] rounded-lg p-5 space-y-4">
                    <h3 class="font-space text-xs font-bold uppercase tracking-wider text-[#F1F5F9] border-b border-[#1E324E] pb-2">SEO Metadata</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block font-space text-[10px] uppercase text-[#64748B] mb-1">SEO Title</label>
                            <input type="text" id="preview_seo_title" value="{{ $data['seo_title'] }}" class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs rounded outline-none focus:border-[#0D7A5F]">
                        </div>
                        <div>
                            <label class="block font-space text-[10px] uppercase text-[#64748B] mb-1">Meta Description</label>
                            <textarea id="preview_meta_desc" rows="3" class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs rounded outline-none focus:border-[#0D7A5F]">{{ $data['meta_description'] }}</textarea>
                        </div>
                        <div>
                            <label class="block font-space text-[10px] uppercase text-[#64748B] mb-1">Slug</label>
                            <input type="text" id="preview_slug" value="{{ $data['slug'] }}" class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs rounded outline-none focus:border-[#0D7A5F]">
                        </div>
                        <div>
                            <label class="block font-space text-[10px] uppercase text-[#64748B] mb-1">Excerpt</label>
                            <textarea id="preview_excerpt" rows="3" class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs rounded outline-none focus:border-[#0D7A5F]">{{ $data['excerpt'] }}</textarea>
                        </div>
                        <div>
                            <label class="block font-space text-[10px] uppercase text-[#64748B] mb-1">Focus Keywords</label>
                            <input type="text" id="preview_keywords" value="{{ $data['focus_keywords'] }}" class="w-full bg-[#0B1526] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs rounded outline-none focus:border-[#0D7A5F]">
                        </div>
                    </div>
                </div>

                <!-- Final Actions -->
                <div class="bg-[#0F2038] border border-[#1E324E] rounded-lg p-5 space-y-3">
                    <h3 class="font-space text-xs font-bold uppercase tracking-wider text-[#F1F5F9] text-center mb-4">Publishing Options</h3>
                    
                    <button onclick="saveArticle('draft')" class="w-full py-3 bg-[#1E324E] hover:bg-[#2A4263] text-white font-space text-xs font-bold uppercase tracking-widest transition rounded">
                        Save as Draft
                    </button>
                    
                    <button onclick="saveArticle('published')" class="w-full py-3 bg-[#0D7A5F] hover:bg-[#10B981] text-white font-space text-xs font-bold uppercase tracking-widest transition rounded">
                        Publish Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addInternalLink() {
    const container = document.getElementById('internal_links_container');
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2 internal-link-row';
    row.innerHTML = `
        <input type="text" class="bg-transparent border border-[#1E324E] text-[#F1F5F9] text-xs w-1/2 p-1 rounded focus:border-[#0D7A5F]" placeholder="Link Text">
        <input type="text" class="bg-transparent border border-[#1E324E] text-[#F1F5F9] text-xs w-1/2 p-1 rounded focus:border[#0D7A5F]" placeholder="URL">
        <button type="button" onclick="removeInternalLink(this)" class="text-xs text-[#94A3B8] hover:text-[#F1F5F9]">✕</button>
    `;
    container.appendChild(row);
}

function removeInternalLink(btn) {
    btn.parentElement.remove();
}

/**
 * Gather internal links from the UI into an array of objects {text, url}
 */
function collectInternalLinks() {
    const rows = document.querySelectorAll('#internal_links_container .internal-link-row');
    const links = [];
    rows.forEach(row => {
        const inputs = row.querySelectorAll('input');
        if (inputs.length >= 2) {
            const text = inputs[0].value.trim();
            const url = inputs[1].value.trim();
            if (text || url) {
                links.push({ text, url });
            }
        }
    });
    return links;
}

async function saveArticle(status) {
    const payload = {
        title: document.getElementById('preview_title').value,
        slug: document.getElementById('preview_slug').value,
        content: document.getElementById('preview_content').value,
        seo_title: document.getElementById('preview_seo_title').value,
        meta_description: document.getElementById('preview_meta_desc').value,
        excerpt: document.getElementById('preview_excerpt').value,
        focus_keywords: document.getElementById('preview_keywords').value,
        status: status,
        // Preserve original context
        category: '{{ request('category') }}',
        service_id: '{{ request('service_id') }}',
        city_id: '{{ request('city_id') }}',
        kecamatan_id: '{{ request('kecamatan_id') }}',
        // Include internal links array
        internal_links: collectInternalLinks(),
    };

    try {
        const response = await fetch('{{ route('admin.articles.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        if (response.ok) {
            alert('Article saved successfully!');
            window.location.href = '{{ route('admin.dashboard', ['tab' => 'articles']) }}';
        } else {
            const err = await response.json();
            alert('Error: ' + (err.message || 'Failed to save article'));
        }
    } catch (e) {
        alert('Connection error occurred.');
    }
}
</script>
@endsection
