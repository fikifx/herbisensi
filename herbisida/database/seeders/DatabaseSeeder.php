<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Evaluasi;
use App\Models\Pemakaian;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder User Login
        User::updateOrCreate(
            ['email' => 'admin@herbi.com'],
            [
                'name' => 'Super Visor',
                'password' => Hash::make('password123'),
            ]
        );

        $blocks = [
            [
                'block_code' => 'A12', 'afdeling' => 'OF', 'luas' => 20,
                'gulma' => 'Ageratum conyzoides (Bandotan)', 'kerapatan' => 'Sedang',
                'herbisida' => 'Glyphosate 480 SL', 'dosis' => 3, 'rekomendasi' => 60,
                'aktual' => 70, 'status' => 'Selesai',
                'pemakaian' => [
                    ['jerigen' => 20, 'batch' => 'G0001', 'waktu' => '2026-06-09 08:15:00'],
                    ['jerigen' => 20, 'batch' => 'G0002', 'waktu' => '2026-06-09 08:32:00'],
                    ['jerigen' => 20, 'batch' => 'G0003', 'waktu' => '2026-06-09 09:05:00'],
                    ['jerigen' => 10, 'batch' => 'G0004', 'waktu' => '2026-06-09 09:40:00'],
                ],
                'evaluasi' => ['efektivitas' => 87, 'kategori' => 'Cukup Efektif',
                    'catatan' => 'Pengendalian cukup efektif, pertahankan teknik aplikasi.'],
            ],
            [
                'block_code' => 'A13', 'afdeling' => 'OF', 'luas' => 15,
                'gulma' => 'Cyperus rotundus (Teki)', 'kerapatan' => 'Tinggi',
                'herbisida' => 'Glyphosate 480 SL', 'dosis' => 3, 'rekomendasi' => 45,
                'aktual' => 0, 'status' => 'Belum Selesai', 'pemakaian' => [], 'evaluasi' => null,
            ],
            [
                'block_code' => 'A14', 'afdeling' => 'OF', 'luas' => 18,
                'gulma' => 'Imperata cylindrica (Alang-alang)', 'kerapatan' => 'Sedang',
                'herbisida' => 'Paraquat Dichloride 276 SL', 'dosis' => 3, 'rekomendasi' => 54,
                'aktual' => 0, 'status' => 'Belum Selesai', 'pemakaian' => [], 'evaluasi' => null,
            ],
            [
                'block_code' => 'B03', 'afdeling' => 'OB', 'luas' => 17,
                'gulma' => 'Mikania micrantha (Sembung rambat)', 'kerapatan' => 'Tinggi',
                'herbisida' => 'Metsulfuron Methyl 20 WG', 'dosis' => 3.1, 'rekomendasi' => 53,
                'aktual' => 61, 'status' => 'Selesai',
                'pemakaian' => [
                    ['jerigen' => 20, 'batch' => 'B0101', 'waktu' => '2026-06-10 07:50:00'],
                    ['jerigen' => 20, 'batch' => 'B0102', 'waktu' => '2026-06-10 08:20:00'],
                    ['jerigen' => 21, 'batch' => 'B0103', 'waktu' => '2026-06-10 08:55:00'],
                ],
                'evaluasi' => ['efektivitas' => 81, 'kategori' => 'Cukup Efektif',
                    'catatan' => 'Sebagian gulma sembung rambat masih tumbuh di tepi blok.'],
            ],
            [
                'block_code' => 'C11', 'afdeling' => 'OH', 'luas' => 16,
                'gulma' => 'Ageratum conyzoides (Bandotan)', 'kerapatan' => 'Sedang',
                'herbisida' => 'Glyphosate 480 SL', 'dosis' => 3, 'rekomendasi' => 49,
                'aktual' => 56, 'status' => 'Selesai',
                'pemakaian' => [
                    ['jerigen' => 20, 'batch' => 'C0201', 'waktu' => '2026-06-11 08:10:00'],
                    ['jerigen' => 20, 'batch' => 'C0202', 'waktu' => '2026-06-11 08:44:00'],
                    ['jerigen' => 16, 'batch' => 'C0203', 'waktu' => '2026-06-11 09:12:00'],
                ],
                'evaluasi' => ['efektivitas' => 84, 'kategori' => 'Cukup Efektif',
                    'catatan' => 'Hasil merata, disarankan monitoring ulang H+14.'],
            ],
            [
                'block_code' => 'D07', 'afdeling' => 'OB', 'luas' => 16,
                'gulma' => 'Cyperus rotundus (Teki)', 'kerapatan' => 'Rendah',
                'herbisida' => 'Glyphosate 480 SL', 'dosis' => 3, 'rekomendasi' => 49,
                'aktual' => 55, 'status' => 'Selesai',
                'pemakaian' => [
                    ['jerigen' => 20, 'batch' => 'D0301', 'waktu' => '2026-06-12 07:40:00'],
                    ['jerigen' => 20, 'batch' => 'D0302', 'waktu' => '2026-06-12 08:05:00'],
                    ['jerigen' => 15, 'batch' => 'D0303', 'waktu' => '2026-06-12 08:35:00'],
                ],
                'evaluasi' => ['efektivitas' => 88, 'kategori' => 'Efektif',
                    'catatan' => 'Kerapatan gulma rendah, dosis mendekati rekomendasi.'],
            ],
            [
                'block_code' => 'E02', 'afdeling' => 'OH', 'luas' => 14,
                'gulma' => 'Imperata cylindrica (Alang-alang)', 'kerapatan' => 'Sedang',
                'herbisida' => 'Paraquat Dichloride 276 SL', 'dosis' => 3, 'rekomendasi' => 43,
                'aktual' => 48, 'status' => 'Selesai',
                'pemakaian' => [
                    ['jerigen' => 20, 'batch' => 'E0401', 'waktu' => '2026-06-12 09:00:00'],
                    ['jerigen' => 20, 'batch' => 'E0402', 'waktu' => '2026-06-12 09:30:00'],
                    ['jerigen' => 8,  'batch' => 'E0403', 'waktu' => '2026-06-12 09:55:00'],
                ],
                'evaluasi' => ['efektivitas' => 85, 'kategori' => 'Cukup Efektif',
                    'catatan' => 'Efektivitas baik, sedikit selisih pemakaian.'],
            ],
        ];

        foreach ($blocks as $blockData) {
            $pemakaianData = $blockData['pemakaian'];
            $evaluasiData  = $blockData['evaluasi'];
            unset($blockData['pemakaian'], $blockData['evaluasi']);

            $block = Block::create($blockData);

            foreach ($pemakaianData as $p) {
                $block->pemakaians()->create($p);
            }

            if ($evaluasiData) {
                $block->evaluasi()->create($evaluasiData);
            }
        }
    }
}
