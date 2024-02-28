<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\CareerTest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PegawaiImport implements ToCollection, WithHeadingRow{

    public $injectDebug = null;

    public function collection(Collection $rows) {
    $imageFileNames = array();
    
    $spreadsheet = IOFactory::load(request()->file('excel_file'));
    foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $index => $drawing) {
            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageBinary = ob_get_contents();
                ob_end_clean();
                switch ($drawing->getMimeType()) {
                    case MemoryDrawing::MIMETYPE_PNG:
                        $extension = 'png';
                        break;
                    case MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case MemoryDrawing::MIMETYPE_JPEG:
                        $extension = 'jpg';
                        break;
                }
            } else {
                $zipReader = fopen($drawing->getPath(), 'r');
                $imageBinary = '';
                while (!feof($zipReader)) {
                    $imageBinary .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();
            }

            $targetDirectory = 'storage/';
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }

            // $myFileName = time() . '_' . $index . '.' . $extension;
            $myFileName = 'photo/' . time() . '_' . $index . '.' . $extension;
            $fileFullPath = $targetDirectory . $myFileName;
            file_put_contents($fileFullPath, $imageBinary);

            $this->injectDebug = mb_convert_encoding($imageBinary, 'UTF-8', 'UTF-8');

            $imageFileNames[$index] = $myFileName;
            
        }

        foreach ($rows as $key => $row) {
            $career_fill_otomatis = CareerTest::where('name', strtoupper($row['posisi']))->first();
            // dump($row);
            if ($career_fill_otomatis) {
                Pegawai::create([
                    'file'          => isset($imageFileNames[$key]) ? $imageFileNames[$key] : null,
                    'nama'          => $row['nama'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'provinsi'      => strtoupper($row['provinsi']),
                    'agama'         => strtoupper($row['agama']),
                    'posisi'        => strtoupper($row['posisi']),
                    'gaji'          => $row['gaji'],
                    'id_posisi'     => $career_fill_otomatis->id_tree,
                    'career_code'   => $career_fill_otomatis->career_code,
                ]);
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

    // WELL, DO NOT USE ToModel INTERFACE

    // public function model(array $row){
    //     $career_fill_otomatis = CareerTest::where('name', strtoupper($row['posisi']))->first();
    //     $imageFileNames = []; 

    //     if($career_fill_otomatis){

    //         $spreadsheet = IOFactory::load(request()->file('excel_file'));
    //         $i = 0;
    //         foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $index => $drawing) {
    //             if ($drawing instanceof MemoryDrawing) {
    //                 ob_start();
    //                 call_user_func(
    //                     $drawing->getRenderingFunction(),
    //                     $drawing->getImageResource()
    //                 );
    //                 $imageContents = ob_get_contents();
    //                 ob_end_clean();
    //                 switch ($drawing->getMimeType()) {
    //                     case MemoryDrawing::MIMETYPE_PNG :
    //                         $extension = 'png';
    //                         break;
    //                     case MemoryDrawing::MIMETYPE_GIF:
    //                         $extension = 'gif';
    //                         break;
    //                     case MemoryDrawing::MIMETYPE_JPEG :
    //                         $extension = 'jpg';
    //                         break;
    //                 }
    //             } else {
    //                 $zipReader = fopen($drawing->getPath(), 'r');
    //                 $imageBinary = '';
    //                 while (!feof($zipReader)) {
    //                     $imageBinary .= fread($zipReader, 1024);
    //                 }
    //                 fclose($zipReader);
    //                 $extension = $drawing->getExtension();
    //             }

    //             $targetDirectory = 'test/';
    //             if (!is_dir($targetDirectory)) {
    //                 // Create the directory if it doesn't exist
    //                 mkdir($targetDirectory, 0755, true);
    //             }

    //             // $myFileName = time() . '.' . $extension;
    //             // $myFileName = time() . '_' . $index . '.' . $extension;
    //             $myFileName = time() . '_' . $index . '.' . $extension;
    //             $fileFullPath = $targetDirectory . $myFileName;
    //             file_put_contents($fileFullPath, $imageBinary);

    //             // file_put_contents('test/' . $myFileName, $imageBinary);
    //             // $extension->storeAs('photo', $myFileName, 'public');
    //             $this->injectDebug = mb_convert_encoding($imageBinary, 'UTF-8', 'UTF-8');
    //             // $this->injectDebug = $drawing;
    //             Pegawai::create([
    //                 'file'          => $myFileName,
    //                 'nama'          => $row['nama'],
    //                 'jenis_kelamin' => $row['jenis_kelamin'],
    //                 'provinsi'      => strtoupper($row['provinsi']),
    //                 'agama'         => strtoupper($row['agama']),
    //                 'posisi'        => strtoupper($row['posisi']),
    //                 'gaji'          => $row['gaji'],
    //                 'id_posisi'     => $career_fill_otomatis->id_tree,
    //                 'career_code'   => $career_fill_otomatis->career_code,
    //             ]);
    //         }
    //     }
