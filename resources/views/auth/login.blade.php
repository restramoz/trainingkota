@extends('layouts.app')

@section('title', 'Admin Login - Training Kota')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-[#0F2038] border border-[#1E324E] p-8 shadow-none relative">
        <div class="absolute top-0 left-0 right-0 h-1 bg-[#0D7A5F]"></div>

        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-[#0B1526] border border-[#1E324E] mb-3 text-[#10B981]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-2xl font-bold font-space text-[#F1F5F9] tracking-tight">TRAININGKOTA<span class="text-[#10B981]">.MY.ID</span></h1>
            <p class="text-[11px] text-[#94A3B8] font-space mt-1 uppercase tracking-widest">System Authentication &bull; Portal CMS Command</p>
        </div>

        @if($errors->any())
            <div class="bg-[#0B1526] border border-[#ffb4ab] text-[#ffdad6] text-xs font-space p-3 mb-5 flex items-center gap-2">
                <span class="text-red-400 font-bold">&#9888;</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-space font-semibold text-[#94A3B8] uppercase mb-1.5">Username Administrator</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus class="input-k3 w-full" placeholder="Masukkan username">
            </div>
            <div>
                <label class="block text-xs font-space font-semibold text-[#94A3B8] uppercase mb-1.5">Password Kredensial</label>
                <input type="password" name="password" required class="input-k3 w-full" placeholder="••••••••••••">
            </div>
            <div class="pt-2">
                <button type="submit" class="btn-primary w-full py-3 text-xs tracking-wider">
                    Autentikasi Sistem &rarr;
                </button>
            </div>
        </form>

        <div class="mt-6 pt-4 border-t border-[#1E324E] text-center">
            <span class="text-[11px] text-[#64748B] font-space">Akses Terbatas: Administrator &amp; Verifikator K3 Wilayah</span>
        </div>
    </div>
</div>
@endsection
