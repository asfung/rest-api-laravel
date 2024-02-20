<?php

namespace Database\Seeders;

use App\Models\CareerTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestCareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // the parent column
            ['career_code' => 'P1', 'name' => 'TECHNOLOGY', 'tree_lvl' => '1', 'id_tree' => '01'],
            ['career_code' => 'P2', 'name' => 'BUSINESS', 'tree_lvl' => '1', 'id_tree' => '02'],
            ['career_code' => 'P3', 'name' => 'HUMAN RESOURCE', 'tree_lvl' => '1', 'id_tree' => '03'],

            ['career_code' => 'P1', 'name' => 'SOFTWARE ENGINEER', 'tree_lvl' => '2', 'id_tree' => '0101'],
            ['career_code' => 'P1', 'name' => 'BACKEND DEV', 'tree_lvl' => '2', 'id_tree' => '010101'],
            ['career_code' => 'P1', 'name' => 'FRONTEND DEV', 'tree_lvl' => '2', 'id_tree' => '010102'],

            ['career_code' => 'P1', 'name' => 'QA ENGINEER', 'tree_lvl' => '2', 'id_tree' => '0102'],
            ['career_code' => 'P1', 'name' => 'DEVOPS', 'tree_lvl' => '2', 'id_tree' => '0103'],
            ['career_code' => 'P1', 'name' => 'FULLSTACK ENGINEER', 'tree_lvl' => '2', 'id_tree' => '0104'],
            ['career_code' => 'P1', 'name' => 'MACHINE LEARNING ENGINEER', 'tree_lvl' => '2', 'id_tree' => '0105'],
            ['career_code' => 'P1', 'name' => 'MECHANICAL ENGINEER', 'tree_lvl' => '2', 'id_tree' => '0106'],

            ['career_code' => 'P2', 'name' => 'SALES MARKETING', 'tree_lvl' => '2', 'id_tree' => '0201'],
            ['career_code' => 'P2', 'name' => 'CHIEF MARKETING', 'tree_lvl' => '2', 'id_tree' => '0202'],
            ['career_code' => 'P2', 'name' => 'LEAD BUSINESS', 'tree_lvl' => '2', 'id_tree' => '0203'],
            ['career_code' => 'P2', 'name' => 'PRODUCT MANAGER', 'tree_lvl' => '2', 'id_tree' => '0204'],

            ['career_code' => 'P3', 'name' => 'RECRUITER', 'tree_lvl' => '2', 'id_tree' => '0301'],
            ['career_code' => 'P3', 'name' => 'PEOPLE DEVELOPMENT', 'tree_lvl' => '2', 'id_tree' => '0302'],
            ['career_code' => 'P3', 'name' => 'EMPLOYEE RELATIONS', 'tree_lvl' => '2', 'id_tree' => '0303'],
        ];

        foreach($data as $key => $value){
            CareerTest::create($value);
        }
    }
}
