<?php

namespace Database\Seeders;

use App\Models\Careers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['career_code' => 'P1', 'name' => 'SOFTWARE ENGINEER'],
            ['career_code' => 'P1', 'name' => 'QA ENGINEER'],
            ['career_code' => 'P1', 'name' => 'DEVOPS'],
            ['career_code' => 'P1', 'name' => 'FULLSTACK ENGINEER'],
            ['career_code' => 'P1', 'name' => 'MACHINE LEARNING ENGINEER'],
            ['career_code' => 'P1', 'name' => 'MECHANICAL ENGINEER'],

            ['career_code' => 'P2', 'name' => 'SALES MARKETING'],
            ['career_code' => 'P2', 'name' => 'CHIEF MARKETING'],
            ['career_code' => 'P2', 'name' => 'LEAD BUSINESS'],
            ['career_code' => 'P2', 'name' => 'PRODUCT MANAGER'],

            ['career_code' => 'P3', 'name' => 'PRODUCT MANAGER'],
        ];

        foreach($data as $key => $value){
            Careers::create($value);
        }

    }
}
