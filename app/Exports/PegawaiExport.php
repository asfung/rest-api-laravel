<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PegawaiExport implements FromCollection, WithHeadings, WithDrawings, WithEvents
{

    private $id_posisi;

    public function __construct($id_posisi){
        $this->id_posisi = $id_posisi;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){

        // if($this->id_posisi === null){
        //     return Pegawai::all()->select('file', 'nama', 'jenis_kelamin', 'provinsi', 'agama', 'posisi', 'gaji')->get();
        // }

        return Pegawai::where('id_posisi', 'like', "$this->id_posisi%")
            ->select('file', 'nama', 'jenis_kelamin', 'provinsi', 'agama', 'posisi', 'gaji') 
            ->get();
        
    }

    public function headings(): array{
        return [
            'File',
            'Nama',
            'Jenis Kelamin',
            'Provinsi',
            'Agama',
            'Posisi',
            'Gaji',
        ];
    }

    public function drawings(){
        $drawings = [];

        foreach ($this->collection() as $key => $pegawai) {
            $imagePath = public_path("/storage/{$pegawai->file}");
            
            if (file_exists($imagePath)) {
                $drawing = new Drawing();
                $drawing->setName($pegawai->nama);
                $drawing->setDescription('Pegawai Image');
                $drawing->setPath($imagePath);
                $drawing->setHeight(90);
                $drawing->setWidth(90);
                $drawing->setCoordinates('A' . ($key + 2));
                $drawings[] = $drawing;
            }else {
                dd("image not found: {$imagePath}");
            }
        }
        return $drawings;
    }

    public function registerEvents(): array{
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                // $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                $highestRow = $event->sheet->getDelegate()->getHighestRow();

                for ($row = 1; $row <= $highestRow; $row++) {
                    $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight(80);
                }

                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
            },
        ];
    }



}
