@extends('layouts.app')

@section('title', 'Daftar Kota - TrainingKota')

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-[#F1F5F9] mb-6">
        Daftar {{ $cities->total() }} Kota
    </h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($cities as $city)
        <div class="bg-[#0E1726] p-4 border border-[#1E293B]">
                <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => $city->slug]) }}" class="text-[#10B981] hover:underline">
                    {{ $city->name }}
                </a>
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $cities->links() }}
    </div>
</div>
@endsection