@extends('admin.layout')

@section('title', 'Coverage Artikel')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#F1F5F9]">Coverage Artikel</h1>
        <div>
            <form method="GET" action="{{ route('admin.articles.coverage') }}" class="flex gap-2 items-center">
                <select name="service_id" class="bg-[#070D18] border border-[#1E293B] text-white rounded-lg px-2 py-1">
                    <option value="">Semua Layanan</option>
                    @foreach($services as $srv)
                        <option value="{{ $srv->id }}" @if($service && $service->id == $srv->id) selected @endif>
                            {{ $srv->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-[#0D7A5F] text-white px-3 py-1 rounded">Filter</button>
            </form>
        </div>
    </div>

    @if($service)
        <p class="mb-4 text-[#F1F5F9]">Menampilkan status artikel untuk layanan: <strong>{{ $service->name }}</strong></p>
    @endif

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-[#0E1726] text-[#F1F5F9]">
                <th class="border border-[#1E293B] px-2 py-1">Kota / Wilayah</th>
                <th class="border border-[#1E293B] px-2 py-1">Status</th>
                <th class="border border-[#1E293B] px-2 py-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cities as $city)
                @php
                    $status = $articleMap[$city->id] ?? null;
                @endphp
                <tr class="{{ $loop->odd ? 'bg-[#070D18]' : 'bg-[#0E1726]' }} text-[#F1F5F9]">
                    <td class="border border-[#1E293B] px-2 py-1">{{ $city->name }}</td>
                    <td class="border border-[#1E293B] px-2 py-1">
                        @if(!$service)
                            -
                        @elseif($status === 'published')
                            Published
                        @elseif($status === 'draft')
                            Draft
                        @else
                            Missing
                        @endif
                    </td>
                    <td class="border border-[#1E293B] px-2 py-1">
                        @if($service && $status !== 'published')
                            <a href="{{ route('admin.articles.create') }}?service_id={{ $service->id }}&city_id={{ $city->id }}"
                               class="text-[#38BDF8] hover:underline">Create</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $cities->links() }}</div>
@endsection
