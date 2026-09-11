@props(['syllabus', 'description' => 'Pembahasan teori, studi implementasi industri, dan bedah regulasi pemerintah terkait keselamatan kerja operasional.'])

<div class="w-full overflow-hidden">
    <!-- Desktop Table -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left border-collapse border border-border-grid bg-regulatory-slate-900">
            <thead class="bg-regulatory-slate-800 border-b border-border-grid">
                <tr>
                    <th class="py-3 px-4 text-xs font-space font-bold text-text-tertiary uppercase tracking-wider w-[8%] text-center">No</th>
                    <th class="py-3 px-4 text-xs font-space font-bold text-text-tertiary uppercase tracking-wider w-[35%]">Materi / Modul</th>
                    <th class="py-3 px-4 text-xs font-space font-bold text-text-tertiary uppercase tracking-wider">Ruang Lingkup / Parameter Teknis</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-grid">
                @foreach($syllabus as $index => $item)
                    <tr class="hover:bg-regulatory-slate-800/50 transition-colors odd:bg-regulatory-slate-900 even:bg-regulatory-slate-900/50">
                        <td class="py-3 px-4 text-xs font-space font-bold text-text-primary text-center border-r border-border-grid">
                            {{ sprintf('%02d', $index + 1) }}
                        </td>
                        <td class="py-3 px-4 text-xs font-space font-semibold text-text-primary border-r border-border-grid" style="overflow-wrap: break-word; word-break: normal; hyphens: none;">
                            {{ $item }}
                        </td>
                        <td class="py-3 px-4 text-xs font-body text-text-secondary leading-relaxed" style="overflow-wrap: break-word; word-break: normal; hyphens: none;">
                            {{ $description }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile Stacked Cards -->
    <div class="md:hidden space-y-4">
        @foreach($syllabus as $index => $item)
            <div class="bg-regulatory-slate-900 border border-border-grid p-4 rounded-sm shadow-sm">
                <div class="flex items-center gap-3 mb-3 border-b border-border-grid pb-2">
                    <span class="w-6 h-6 bg-regulatory-slate-800 border border-border-grid text-safety-emerald-bright font-space font-bold text-[10px] flex items-center justify-center shrink-0">
                        {{ sprintf('%02d', $index + 1) }}
                    </span>
                    <h3 class="font-space font-bold text-xs text-text-primary uppercase tracking-tight" style="overflow-wrap: break-word; word-break: normal; hyphens: none;">
                        {{ $item }}
                    </h3>
                </div>
                <div class="pl-9">
                    <span class="text-[10px] font-label-caps text-text-tertiary uppercase block mb-1">Ruang Lingkup:</span>
                    <p class="text-[11px] text-text-secondary leading-relaxed font-body" style="overflow-wrap: break-word; word-break: normal; hyphens: none;">
                        {{ $description }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
