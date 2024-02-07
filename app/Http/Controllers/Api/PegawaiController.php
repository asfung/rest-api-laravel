<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PegawaiController extends Controller
{
    public function findAll(){
        $pegawai = Pegawai::all();
        return response()->json($pegawai);
    }

    public function addPegawai(Request $request){
        try {
            $this->validate($request, [
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'kota' => 'required',
                'agama' => 'required',
                'posisi' => 'required',
                'gaji' => 'required',
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => 'data yang diisi harus lengkap',
                'errors' => $exception->validator->errors()
            ], 404);
        }

        $pegawai = new Pegawai();
        $pegawai->nama = $request->nama;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->kota = $request->kota;
        $pegawai->agama = $request->agama;
        $pegawai->gaji = $request->gaji;
        $pegawai->posisi = $request->posisi;
        $pegawai->save();
        return response()->json([
            'message' => 'pegawai Ditambahkan!'
        ], 201);

    }

    public function findById($id){
        $pegawai = Pegawai::find($id);
        if(!empty($pegawai)){
            return response()->json($pegawai);
        }else{
            return response([
                'message' => 'pegawai tidak ada'
            ], 404);
        }
    }

    public function updateById(Request $request, $id){
        if(Pegawai::where('id', $id)->exists()){
            $pegawai = Pegawai::find($id);
            $pegawai->nama = is_null($request->nama) ? $pegawai->nama : $request->nama;
            $pegawai->jenis_kelamin = is_null($request->jenis_kelamin) ? $pegawai->jenis_kelamin : $request->jenis_kelamin;
            $pegawai->kota = is_null($request->kota) ? $pegawai->kota : $request->kota;
            $pegawai->agama = is_null($request->agama) ? $pegawai->agama : $request->agama;
            $pegawai->gaji = is_null($request->gaji) ? $pegawai->gaji : $request->gaji;
            $pegawai->posisi = is_null($request->posisi) ? $pegawai->posisi : $request->posisi;
            $pegawai->save();
            return response()->json([
                'message' => 'pegawai telah diupdate!'
            ], 200);
        }else{
            return response()->json([
                'message' => 'pegawai not found'
            ], 404);
        }
    }

    public function deleteById($id){
        $isExist = Pegawai::where('id', $id)->exists();
        if($isExist){
            $pegawai = Pegawai::find($id);
            $pegawai->delete();
            return response()->json([
                'message' => 'pegawai terhapus!'
            ],200);
        }else{
            return response()->json([
                'message' => 'pegawai not found'
            ], 404);
        }
    }

}
