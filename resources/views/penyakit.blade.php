@extends('layouts.app')

@section('content')
<h2 class="text-3xl font-bold mb-10 text-center text-primary">
    Daftar Penyakit Kulit Kucing
</h2>

@php
$penyakit = [
    [
        'nama' => 'Scabies',
        'deskripsi' => 'Penyakit kulit akibat tungau yang menyebabkan gatal hebat dan luka.',
        'gejala' => [
            'Gatal berlebihan',
            'Luka atau keropeng',
            'Sering menggaruk area tertentu'
        ]
    ],
    [
        'nama' => 'Dermatitis Alergi',
        'deskripsi' => 'Reaksi alergi terhadap makanan, debu, atau gigitan parasit.',
        'gejala' => [
            'Kulit kemerahan',
            'Gatal berlebihan',
            'Iritasi kulit'
        ]
    ],
    [
        'nama' => 'Jamur Kulit',
        'deskripsi' => 'Infeksi jamur yang menyebabkan kerontokan dan kulit bersisik.',
        'gejala' => [
            'Bulu rontok',
            'Kulit bersisik',
            'Rambut menipis'
        ]
    ],
    [
        'nama' => 'Infeksi Bakteri',
        'deskripsi' => 'Infeksi bakteri yang menyebabkan luka bernanah dan peradangan.',
        'gejala' => [
            'Luka bernanah',
            'Kulit lembab',
            'Kulit kemerahan'
        ]
    ],
    [
        'nama' => 'Kutu / Parasit Kulit',
        'deskripsi' => 'Infeksi parasit yang menyebabkan rasa gatal dan ketidaknyamanan.',
        'gejala' => [
            'Gatal berlebihan',
            'Bulu rontok',
            'Kulit berbau tidak sedap'
        ]
    ],
];
@endphp

<div class="grid md:grid-cols-3 gap-8">
    @foreach ($penyakit as $item)
        <div
            class="bg-card rounded-xl p-6 shadow-lg
                   hover:shadow-primary/30 hover:-translate-y-1
                   transition duration-300">

            <h3 class="text-xl font-bold text-primary mb-2">
                {{ $item['nama'] }}
            </h3>

            <p class="text-textsoft text-sm mb-4">
                {{ $item['deskripsi'] }}
            </p>

            <div>
                <h4 class="font-semibold text-sm mb-2">
                    Gejala Umum:
                </h4>
                <ul class="list-disc list-inside text-sm text-textsoft space-y-1">
                    @foreach ($item['gejala'] as $g)
                        <li>{{ $g }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection
