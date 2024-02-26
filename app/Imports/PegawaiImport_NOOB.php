<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\CareerTest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row){
        $getIdPosisi = CareerTest::where('name', strtoupper($row['posisi']))->get();
        $id_posisi = null;
        $career_code = null;
        foreach($getIdPosisi as $value){
            $id_posisi = $value->id_tree;
            $career_code = $value->career_code;
        }
        return new Pegawai([
            'file' => $this->saveImage($row['file']),
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'provinsi' => strtoupper($row['provinsi']),
            'agama' => strtoupper($row['agama']),
            'posisi' => strtoupper($row['posisi']),
            'gaji' => $row['gaji'],
            'id_posisi' => $id_posisi,
            'career_code' => $career_code,
        ]);

        // $getIdPosisi = CareerTest::where('name', strtoupper($row['posisi']))->get();
        // $id_posisi = null;
        // $career_code = null;
        // foreach($getIdPosisi as $value){
        //     $id_posisi = $value->id_tree;
        //     $career_code = $value->career_code;
        // }
        // return new Pegawai([
        //     'file' => $this->saveImage($row['file']),
        //     'nama' => $row['nama'],
        //     'jenis_kelamin' => $row['jenis_kelamin'],
        //     'provinsi' => strtoupper($row['provinsi']),
        //     'agama' => strtoupper($row['agama']),
        //     'posisi' => strtoupper($row['posisi']),
        //     'gaji' => $row['gaji'],
        //     'id_posisi' => $id_posisi,
        //     'career_code' => $career_code,
        // ]);
    }

    private function saveImage($file){
        // Logic to save the image and return the file name
        // You may use storage, intervention/image, etc.
        // Example: 
        // $imageName = time().'.'.$file->extension(); 
        // $file->storeAs('public/photo', $imageName);
        // return $imageName;

        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('photo', $filename, 'public');
        return $filename;

    }
}
