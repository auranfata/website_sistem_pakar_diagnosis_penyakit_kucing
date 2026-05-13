<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
    // MASTER DATA
    private array $gejalaMaster = [
    'G01' => 'Gatal berlebihan',
    'G02' => 'Sering menggaruk area tertentu',
    'G03' => 'Terdapat luka atau keropeng',
    'G04' => 'Kulit kemerahan atau iritasi',
    'G05' => 'Bulu rontok membentuk pola tertentu',
    'G06' => 'Kulit bersisik atau berketombe',
    'G07' => 'Rambut menipis',
    'G08' => 'Kulit berbau tidak sedap',
    'G09' => 'Kulit tampak lembab atau bernanah',
    'G10' => 'Kucing sering menjilat area tertentu',
];
   private array $penyakit = [

    'Scabies (Kudis Kucing)' => [
        'gejala' => [
            'G01' => 0.4, // gatal berlebihan (sangat penting)
            'G02' => 0.3, // sering menggaruk
            'G03' => 0.3, // luka / keropeng
        ],
        'deskripsi' => 'Penyakit kulit akibat tungau yang menyebabkan gatal hebat dan luka.',
        'penanganan' => [
            'Isolasi kucing',
            'Sampo anti tungau',
            'Bersihkan kandang',
            'Konsultasi dokter hewan'
        ]
    ],

    'Jamur Kulit (Ringworm)' => [
        'gejala' => [
            'G05' => 0.4, // bulu rontok pola
            'G06' => 0.35, // bersisik
            'G07' => 0.25, // rambut menipis
        ],
        'deskripsi' => 'Infeksi jamur yang menyebabkan kerontokan dan kulit bersisik.',
        'penanganan' => [
            'Obat antijamur',
            'Jaga area tetap kering',
            'Sterilisasi kandang'
        ]
    ],

    'Dermatitis Alergi' => [
        'gejala' => [
            'G01' => 0.35,
            'G04' => 0.35,
            'G10' => 0.3,
        ],
        'deskripsi' => 'Reaksi alergi terhadap makanan atau lingkungan.',
        'penanganan' => [
            'Hindari alergen',
            'Obat anti alergi',
            'Perawatan kulit'
        ]
    ],
];

    public function index()
    {
        return view('diagnosa', [
            'gejala' => $this->gejalaMaster
        ]);
    }

    public function proses(Request $request)
    {
        $request->validate([
            'gejala' => 'required|array|min:1'
        ]);

        $dipilihKode = $request->gejala;

        // Konversi ke nama gejala
        $dipilihNama = array_map(
            fn($kode) => $this->gejalaMaster[$kode] ?? '',
            $dipilihKode
        );

       $hasilAkhir = [
    'nama' => 'Tidak terdeteksi penyakit spesifik',
    'keyakinan' => 0,
    'deskripsi' => '',
    'penanganan' => []
];

foreach ($this->penyakit as $nama => $data) {

    $totalBobot = array_sum($data['gejala']);
    $bobotCocok = 0;

    foreach ($data['gejala'] as $kode => $bobot) {
        if (in_array($kode, $dipilihKode)) {
            $bobotCocok += $bobot;
        }
    }

    $persen = round(($bobotCocok / $totalBobot) * 100);

    if ($persen > $hasilAkhir['keyakinan']) {
        $hasilAkhir = [
            'nama' => $nama,
            'keyakinan' => $persen,
            'deskripsi' => $data['deskripsi'],
            'penanganan' => $data['penanganan']
        ];
    }
}

        return view('hasil', [
            'hasil' => $hasilAkhir,
            'dipilih' => $dipilihNama
        ]);
    }
}
