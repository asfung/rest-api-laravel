<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $religions = [
            ['agama' => 'ISLAM'],
            ['agama' => 'KRISTEN PROTESTAN'],
            ['agama' => 'KRISTEN KATOLIK'],
            ['agama' => 'HINDU'],
            ['agama' => 'BUDDHA'],
            ['agama' => 'KONGHUCU'],
        ];

        foreach ($religions as $key => $value) {
            Agama::create($value);
        }
    }
}
