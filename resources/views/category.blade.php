@extends('layouts.app')

@section('content')
<!-- Header Category Banner -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-14">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center space-x-2 text-xs font-space uppercase text-[#94A3B8] mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <span class="text-[#10B981] font-semibold">{{ strtoupper($category) }}</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge-kemnaker">{{ strtoupper($category) }} RESMI</span>
                    <span class="text-xs font-space text-[#94A3B8]">{{ count($services) }} Program Terdaftar</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold font-space text-[#F1F5F9]">
                    {{ $categoryTitle }}
                </h1>
                <p class="text-sm sm:text-base text-[#94A3B8] mt-2 max-w-3xl font-body">
                    {{ $categorySubtitle }}
                </p>
            </div>

            <!-- Switch category pills -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('category.show', 'pelatihan') }}" class="px-3 py-1.5 text-xs font-space uppercase {{ $category === 'pelatihan' ? 'bg-[#0D7A5F] text-white border border-[#0D7A5F]' : 'bg-[#0B1526] text-[#94A3B8] border border-[#1E324E] hover:text-white' }}">
                    Pelatihan (53)
                </a>
                <a href="{{ route('category.show', 'kajian') }}" class="px-3 py-1.5 text-xs font-space uppercase {{ $category === 'kajian' ? 'bg-[#0D7A5F] text-white border border-[#0D7A5F]' : 'bg-[#0B1526] text-[#94A3B8] border border-[#1E324E] hover:text-white' }}">
                    Kajian (3)
                </a>
                <a href="{{ route('category.show', 'jasa') }}" class="px-3 py-1.5 text-xs font-space uppercase {{ $category === 'jasa' ? 'bg-[#0D7A5F] text-white border border-[#0D7A5F]' : 'bg-[#0B1526] text-[#94A3B8] border border-[#1E324E] hover:text-white' }}">
                    Jasa (6)
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Search in Category -->
<section class="py-6 bg-[#0B1526] border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs font-space text-[#94A3B8] uppercase">
            MENAMPILKAN <span class="text-[#F1F5F9] font-bold">{{ count($services) }}</span> LAYANAN DI KATALOG {{ strtoupper($category) }}
        </div>
        <div class="w-full sm:w-80">
            <input 
                type="text" 
                id="service-search-input" 
                placeholder="Cari program layanan ini..." 
                class="input-k3 w-full text-xs font-space"
                oninput="filterServices(this.value)"
            >
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="service-card bg-[#0B1526] border border-[#1E324E] p-6 flex flex-col justify-between hover:border-[#0D7A5F] transition-all" data-name="{{ strtolower($service->name) }}">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="badge-kemnaker text-[10px]">{{ $service->badge }}</span>
                            <span class="text-xs font-space text-[#10B981] font-semibold">{{ $service->duration }}</span>
                        </div>
                        
                        <h2 class="text-lg font-bold font-space text-[#F1F5F9]">
                            <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $service->slug]) }}" class="hover:text-[#10B981] transition-colors">
                                {{ $service->name }}
                            </a>
                        </h2>

                        <p class="text-xs text-[#94A3B8] leading-relaxed line-clamp-3">
                            {{ $service->description }}
                        </p>

                        <!-- Quick Syllabus Points (Pelatihan Only) -->
                        @if($category === 'pelatihan' && !empty($service->syllabus) && is_array($service->syllabus))
                            <div class="border-t border-[#142338] pt-3 space-y-1">
                                @foreach(array_slice($service->syllabus, 0, 2) as $point)
                                    <div class="text-[11px] text-[#c5c6ce] flex items-center gap-1.5">
                                        <span class="text-[#0D7A5F] font-bold">&#10003;</span>
                                        <span class="truncate">{{ $point }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="pt-6 mt-6 border-t border-[#1E324E] flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-[#10B981] font-space text-xs">
                            <span class="w-2 h-2 bg-[#10B981] inline-block"></span>
                            <span class="text-[11px] uppercase font-bold">{{ $service->badge ?? 'Kemnaker RI' }}</span>
                        </div>
                        <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $service->slug]) }}" class="btn-primary text-xs py-2 px-3.5">
                            Detail Layanan &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="no-service-found" class="hidden p-8 bg-[#0F2038] border border-[#1E324E] text-center text-[#94A3B8] font-space text-sm mt-6">
            Program tidak ditemukan. Silakan hubungi tim kami untuk pengajuan silabus kustom.
        </div>
    </div>
</section>

<!-- Quick City Selector for this Category -->
<section class="py-12 bg-[#0F2038] border-t border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="border-b border-[#1E324E] pb-4 mb-6 flex items-center justify-between">
            <h3 class="font-space font-bold text-sm uppercase text-[#F1F5F9] tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                Pelaksanaan {{ ucfirst($category) }} di Kota Pilihan Anda
            </h3>
            <a href="{{ route('home') }}#widget-kota" class="text-xs text-[#38BDF8] font-space hover:underline">
                Lihat Semua 212 Kota &rarr;
            </a>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach($hubCities as $hub)
                <a href="{{ route('city.landing', ['category' => $category, 'citySlug' => $hub->slug]) }}" class="px-3 py-1.5 bg-[#070D18] border border-[#1E324E] hover:border-[#0D7A5F] text-[#F1F5F9] hover:text-[#10B981] text-xs font-space uppercase">
                    {{ ucfirst($category) }} di {{ $hub->name }} &rarr;
                </a>
            @endforeach
        </div>
    </div>
</section>

<script>
function filterServices(query) {
    query = query.toLowerCase().trim();
    const cards = document.querySelectorAll('.service-card');
    let visible = 0;

    cards.forEach(c => {
        const name = c.getAttribute('data-name');
        if (!query || name.includes(query)) {
            c.style.display = 'flex';
            visible++;
        } else {
            c.style.display = 'none';
        }
    });

    document.getElementById('no-service-found').classList.toggle('hidden', visible > 0);
}
</script>
@endsection

