@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold text-center text-sky-600 mb-2">
        Hasil Diagnosa
    </h2>
    <p class="text-center text-slate-500 mb-8">
        Berdasarkan gejala yang Anda pilih, berikut adalah hasil analisis sistem.
    </p>

    {{-- Card Hasil Utama --}}
    <div class="bg-sky-50 border border-sky-200 rounded-xl p-6 mb-8">
        <h3 class="text-xl font-semibold text-sky-700 mb-2">
            {{ $hasil['nama'] }}
        </h3>

        <p class="text-slate-600 mb-4">
            {{ $hasil['deskripsi'] ?: 'Tidak tersedia deskripsi untuk penyakit ini.' }}
        </p>

        {{-- Tingkat Keyakinan --}}
        <div class="mb-4">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-sky-700">
                    Tingkat Keyakinan
                </span>
                <span class="text-sm font-semibold text-sky-700">
                    {{ $hasil['keyakinan'] }}%
                </span>
            </div>
            <div class="w-full bg-sky-100 rounded-full h-3">
                <div class="bg-sky-500 h-3 rounded-full"
                     style="width: {{ $hasil['keyakinan'] }}%">
                </div>
            </div>
        </div>

        {{-- Catatan --}}
        <p class="text-xs text-slate-500 mt-3">
            * Persentase menunjukkan tingkat kecocokan antara gejala yang dipilih dengan aturan penyakit.
        </p>
    </div>

    {{-- Gejala Dipilih --}}
    <div class="mb-8">
        <h4 class="text-lg font-semibold text-slate-700 mb-3">
            Gejala yang Dipilih
        </h4>

        <ul class="grid sm:grid-cols-2 gap-3">
            @foreach ($dipilih as $gejala)
                <li class="flex items-center gap-2 bg-slate-50 border rounded-lg px-4 py-2">
                    <span class="w-2 h-2 bg-sky-400 rounded-full"></span>
                    <span class="text-slate-600">{{ $gejala }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Penanganan --}}
    @if (!empty($hasil['penanganan']))
    <div class="mb-10">
        <h4 class="text-lg font-semibold text-slate-700 mb-3">
            Saran Penanganan Awal
        </h4>

        <ul class="space-y-2">
            @foreach ($hasil['penanganan'] as $item)
                <li class="flex items-start gap-3">
                    <span class="text-sky-500 mt-1">✔</span>
                    <span class="text-slate-600">{{ $item }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Disclaimer --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-8">
        <p class="text-sm text-yellow-700">
            ⚠️ Hasil diagnosa ini bersifat <strong>edukatif dan pendukung keputusan</strong>.
            Untuk penanganan medis yang tepat, disarankan berkonsultasi langsung dengan dokter hewan.
        </p>
    </div>

    {{-- Aksi --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="/diagnosa"
           class="bg-sky-500 hover:bg-sky-600 text-white px-6 py-3 rounded-lg text-center font-semibold">
            Diagnosa Ulang
        </a>

        <a href="/penyakit"
           class="bg-white border border-sky-300 hover:bg-sky-50 text-sky-600 px-6 py-3 rounded-lg text-center font-semibold">
            Lihat Daftar Penyakit
        </a>
    </div>

</div>
@endsection
