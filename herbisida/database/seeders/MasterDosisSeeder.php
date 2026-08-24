<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('master_dosis.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            \App\Models\MasterDosis::create($item);
        }
    }
}
