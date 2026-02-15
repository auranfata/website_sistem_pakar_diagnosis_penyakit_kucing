@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-card p-8 rounded-xl shadow space-y-6">

    <h2 class="text-3xl font-bold text-center text-primary">
        Hasil Diagnosa
    </h2>

    <div class="bg-secondary p-6 rounded-lg">
        <p class="text-lg mb-2 text-textmain">
            Penyakit Terindikasi:
        </p>
        <p class="text-2xl font-semibold text-textmain">
            {{ $hasil }}
        </p>

        <div class="mt-4">
            <p class="mb-1">Tingkat Keyakinan:</p>
            <div class="w-full bg-slate-600 rounded-full h-4">
                <div class="bg-success h-4 rounded-full"
                     style="width: {{ $keyakinan }}%">
                </div>
            </div>
            <p class="mt-1 text-sm text-textmain">
                {{ $keyakinan }}%
            </p>
        </div>
    </div>

    <div class="bg-secondary p-6 rounded-lg">
        <h3 class="text-xl font-semibold mb-3 text-textmain">
            Gejala yang Dipilih
        </h3>
        <ul class="list-disc list-inside text-textmain">
            @foreach ($dipilih as $g)
                <li>{{ $g }}</li>
            @endforeach
        </ul>
    </div>

    @if (count($penanganan) > 0)
    <div class="bg-secondary p-6 rounded-lg">
        <h3 class="text-xl font-semibold mb-3 text-textmain">
            Saran Penanganan Awal
        </h3>
        <ul class="list-disc list-inside text-textmain">
            @foreach ($penanganan as $saran)
                <li>{{ $saran }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="text-center">
        <a href="/diagnosa"
           class="inline-block bg-primary hover:bg-hover text-white px-6 py-3 rounded-lg font-semibold">
            Diagnosa Ulang
        </a>
    </div>

</div>
@endsection
