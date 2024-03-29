<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model 
{
    use HasFactory;
    protected $fillable = ['file', 'nama', 'jenis_kelamin','provinsi', 'agama', 'posisi', 'gaji', 'id_posisi', 'career_code'];
}
