<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakerData = \Faker\Factory::create();
        for ($i=0; $i < 10; $i++) { 
            Quote::create([
                'author' => $fakerData->name,
                'quote' => $fakerData->sentence,
            ]);
        }
    }
}
