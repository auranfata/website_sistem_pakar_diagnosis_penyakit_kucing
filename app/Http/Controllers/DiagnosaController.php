<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
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
            'gejala' => ['G01' => 0.4, 'G02' => 0.3, 'G03' => 0.3],
            'deskripsi' => 'Penyakit kulit akibat tungau yang menyebabkan gatal hebat dan luka.',
            'penanganan' => ['Isolasi kucing', 'Sampo anti tungau', 'Bersihkan kandang', 'Konsultasi dokter hewan']
        ],
        'Jamur Kulit (Ringworm)' => [
            'gejala' => ['G05' => 0.4, 'G06' => 0.35, 'G07' => 0.25],
            'deskripsi' => 'Infeksi jamur yang menyebabkan kerontokan dan kulit bersisik.',
            'penanganan' => ['Obat antijamur', 'Jaga area tetap kering', 'Sterilisasi kandang']
        ],
        'Dermatitis Alergi' => [
            'gejala' => ['G01' => 0.35, 'G04' => 0.35, 'G10' => 0.3],
            'deskripsi' => 'Reaksi alergi terhadap makanan atau lingkungan.',
            'penanganan' => ['Hindari alergen', 'Obat anti alergi', 'Perawatan kulit']
        ],
    ];

    public function index()
    {
        return view('diagnosa', ['gejala' => $this->gejalaMaster]);
    }

    public function proses(Request $request)
    {
        $request->validate(['gejala' => 'required|array|min:1']);
        $dipilihKode = $request->gejala;
        $penaltyWeight = 0.1; // Bobot penalti per gejala tidak relevan

        $daftarHasil = [];

        foreach ($this->penyakit as $nama => $data) {
            $totalBobotPenyakit = array_sum($data['gejala']);
            $bobotCocok = 0;
            $gejalaTidakRelevan = 0;

            // Hitung gejala yang cocok dan yang tidak relevan
            foreach ($dipilihKode as $kodeUser) {
                if (isset($data['gejala'][$kodeUser])) {
                    $bobotCocok += $data['gejala'][$kodeUser];
                } else {
                    $gejalaTidakRelevan++;
                }
            }

            // Rumus dengan Faktor Penalti
            // Persentase = (Bobot Cocok / (Total Bobot Penyakit + (Jumlah Gejala Ekstra * Penalty)))
            $pembagi = $totalBobotPenyakit + ($gejalaTidakRelevan * $penaltyWeight);
            $persen = round(($bobotCocok / $pembagi) * 100);

            $daftarHasil[] = [
                'nama' => $nama,
                'keyakinan' => $persen,
                'deskripsi' => $data['deskripsi'],
                'penanganan' => $data['penanganan']
            ];
        }

        // Urutkan berdasarkan keyakinan tertinggi (Differential Diagnosis)
        usort($daftarHasil, fn($a, $b) => $b['keyakinan'] <=> $a['keyakinan']);

        return view('hasil', [
            'hasilUtama' => $daftarHasil[0],
            'alternatif' => array_slice($daftarHasil, 1),
            'dipilih' => array_map(fn($k) => $this->gejalaMaster[$k], $dipilihKode)
        ]);
    }
}
