<?php

namespace Database\Seeders;

use App\Models\CareersParent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['TECHNOLOGY', 'BUSINESS', 'HUMAN RESOURCE'];
        for ($i = 0; $i < count($data); ++$i) {
            CareersParent::create([
                'career_code' => 'P' . ($i + 1),
                'name' => $data[$i],
            ]);
        }
    }
}
