<?php

namespace App\Imports;

use App\Models\CareerTest;
use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows){
        foreach($rows as $row){
            $career_fill_otomatis = CareerTest::where('name', strtoupper($row['posisi']))->first();
            dump($row);
            if($career_fill_otomatis){
                Pegawai::create([
                    'file' => $this->saveImage($row['file']),
                    'nama' => $row['nama'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'provinsi' => strtoupper($row['provinsi']),
                    'agama' => strtoupper($row['agama']),
                    'posisi' => strtoupper($row['posisi']),
                    'gaji' => $row['gaji'],
                    'id_posisi' => $career_fill_otomatis->id_tree,
                    'career_code' => $career_fill_otomatis->career_code,
                ]);

                // dump($career_fill_otomatis->career_code);
                // dump($career_fill_otomatis->id_tree);
            }else{
                dd('career not found');
            }
        }
    }


    private function saveImage($file){
        if($file){
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('photo', $filename, 'public');
            return $filename;
        }

        return 'file tidak ada';

    }
}
