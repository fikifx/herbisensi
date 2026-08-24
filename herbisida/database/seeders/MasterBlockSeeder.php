<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('master_bloks.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            \App\Models\MasterBlock::updateOrCreate(
                ['block_code' => $item['block_code']],
                [
                    'luas_tanam' => $item['luas_tanam'],
                    'tahun_tanam' => $item['tahun_tanam'],
                    'jumlah_pokok' => $item['jumlah_pokok'],
                    'topografi' => $item['topografi'],
                    'umur_tanam' => $item['umur_tanam'],
                    'kategori_umur' => $item['kategori_umur'],
                ]
            );
        }
    }
}
