@extends('admin.layout')

@section('title', 'Daftar Artikel')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#F1F5F9]">Manajemen Artikel</h1>
            <p class="text-slate-400 text-sm">Kelola konten artikel dan target geografis</p>
        </div>
        <!-- Direct link to Create Article -->
        <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Artikel
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-[#0E1726] p-4 rounded-xl border border-[#1E293B] mb-6">
        <form action="{{ route('admin.articles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau keyword..." class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none" />
            </div>
            <div>
                <select name="category" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition">Filter</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-[#0E1726] rounded-xl border border-[#1E293B]">
        <table class="min-w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#161F2E] border-b border-[#1E293B]">
                    <th class="px-6 py-3 text-sm font-semibold text-slate-300">Judul</th>
                    <th class="px-6 py-3 text-sm font-semibold text-slate-300">Targeting</th>
                    <th class="px-6 py-3 text-sm font-semibold text-slate-300">Kategori</th>
                    <th class="px-6 py-3 text-sm font-semibold text-slate-300">Status</th>
                    <th class="px-6 py-3 text-sm font-semibold text-slate-300">Tanggal</th>
                    <th class="px-6 py-3 text-sm font-semibold text-slate-300 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1E293B]">
                @forelse($articles as $article)
                <tr class="hover:bg-[#1E324E] transition">
                    <td class="px-4 py-4">
                        <div class="font-semibold text-[#F1F5F9]">{{ $article->title }}</div>
                        <div class="text-xs text-[#64748B]">{{ $article->slug }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-[#F1F5F9]">
                            {{ $article->city?->name ?? 'Global' }}
                            @if($article->kecamatan)
                                - {{ $article->kecamatan->name }}
                            @endif
                        </div>
                        <div class="text-xs text-[#64748B]">{{ $article->service?->name ?? 'Umum' }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-800 text-gray-300 border border-gray-700">
                            {{ ucfirst($article->category) }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        @if($article->status === 'published')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-900/30 text-green-400 border border-green-800/50">Published</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-900/30 text-yellow-400 border border-yellow-800/50">Draft</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm text-[#94A3B8]">
                        {{ $article->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-4 text-right space-x-2">
                        <a href="{{ route('admin.articles.show', $article->id) }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium">View</a>
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-medium">Edit</a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-[#64748B]">Tidak ada artikel ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
</div>
@endsection
