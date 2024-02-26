<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows){
        foreach($rows as $row){
            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password']
            ]);
        }
    }
}
