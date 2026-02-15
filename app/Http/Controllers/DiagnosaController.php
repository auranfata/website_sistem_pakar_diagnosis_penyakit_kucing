<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
    public function index()
    {
        $gejala = [
            'G01' => 'Gatal berlebihan',
            'G02' => 'Bulu rontok di beberapa bagian',
            'G03' => 'Kulit kemerahan atau iritasi',
            'G04' => 'Terdapat luka atau keropeng',
            'G05' => 'Kulit bersisik atau berketombe',
            'G06' => 'Rambut menipis',
            'G07' => 'Sering menggaruk area tertentu',
            'G08' => 'Kulit berbau tidak sedap',
            'G09' => 'Kulit tampak lembab atau bernanah',
        ];

        return view('diagnosa', compact('gejala'));
    }

    public function proses(Request $request)
{
    $request->validate([
        'gejala' => 'required|array|min:1'
    ]);

    // MASTER GEJALA (kode => nama)
    $gejalaMaster = [
        'G01' => 'Gatal berlebihan',
        'G02' => 'Bulu rontok di beberapa bagian',
        'G03' => 'Kulit kemerahan atau iritasi',
        'G04' => 'Terdapat luka atau keropeng',
        'G05' => 'Kulit bersisik atau berketombe',
        'G06' => 'Rambut menipis',
        'G07' => 'Sering menggaruk area tertentu',
        'G08' => 'Kulit berbau tidak sedap',
        'G09' => 'Kulit tampak lembab atau bernanah',
    ];

    $dipilihKode = $request->gejala;

    // UBAH KODE → TEKS
    $dipilihNama = [];
    foreach ($dipilihKode as $kode) {
        if (isset($gejalaMaster[$kode])) {
            $dipilihNama[] = $gejalaMaster[$kode];
        }
    }

    // RULE BASED
    $rules = [
        'Scabies' => ['G01', 'G04', 'G07'],
        'Dermatitis Alergi' => ['G01', 'G03', 'G07'],
        'Jamur Kulit' => ['G02', 'G05', 'G06'],
        'Infeksi Bakteri' => ['G03', 'G04', 'G09'],
        'Kutu / Parasit Kulit' => ['G01', 'G02', 'G07', 'G08'],
    ];

    $penanganan = [
        'Scabies' => [
            'Mandikan dengan sampo anti tungau',
            'Isolasi sementara',
            'Bersihkan kandang',
            'Konsultasi dokter hewan'
        ],
        'Dermatitis Alergi' => [
            'Hindari alergen',
            'Gunakan obat anti alergi',
            'Jaga kebersihan kulit'
        ],
        'Jamur Kulit' => [
            'Gunakan obat antijamur',
            'Jaga area tetap kering',
            'Sterilisasi kandang'
        ],
        'Infeksi Bakteri' => [
            'Bersihkan luka',
            'Gunakan antibiotik',
            'Pantau kondisi'
        ],
        'Kutu / Parasit Kulit' => [
            'Obat anti parasit',
            'Mandikan rutin',
            'Cuci alas tidur'
        ],
    ];

    $hasil = 'Tidak terdeteksi penyakit spesifik';
    $keyakinan = 0;

    foreach ($rules as $penyakit => $ruleGejala) {
        $cocok = count(array_intersect($dipilihKode, $ruleGejala));
        $persen = round(($cocok / count($ruleGejala)) * 100);

        if ($persen > $keyakinan) {
            $keyakinan = $persen;
            $hasil = $penyakit;
        }
    }

    return view('hasil', [
        'hasil' => $hasil,
        'keyakinan' => $keyakinan,
        'dipilih' => $dipilihNama,
        'penanganan' => $penanganan[$hasil] ?? []
    ]);
}
}
