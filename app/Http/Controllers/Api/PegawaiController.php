<?php

namespace App\Http\Controllers\Api;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Careers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\Foreach_;

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
                'provinsi' => 'required',
                // 'provinsiId' => 'required',
                'agama' => 'required',
                'posisi' => 'required',
                'gaji' => 'required',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        $pegawai->provinsi = $request->provinsi;
        // $pegawai->provinsiId = $request->provinsiId;
        $pegawai->agama = $request->agama;
        $pegawai->gaji = $request->gaji;
        $pegawai->posisi = $request->posisi;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photo', $filename, 'public');
            $pegawai->file = $path;
        }

        $getIdPosisi = Careers::where('name', $request->posisi)->get();
        foreach($getIdPosisi as $value){
            $pegawai->id_posisi = $value->id;
        }

        $pegawai->save();
        return response()->json([
            'message' => 'pegawai Ditambahkan!',
            'idk' => $getIdPosisi
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
            $pegawai->provinsi = is_null($request->provinsi) ? $pegawai->provinsi : $request->provinsi;
            // $pegawai->provinsiId = is_null($request->provinsiId) ? $pegawai->provinsiId : $request->provinsiId;
            $pegawai->agama = is_null($request->agama) ? $pegawai->agama : $request->agama;
            $pegawai->gaji = is_null($request->gaji) ? $pegawai->gaji : $request->gaji;
            $pegawai->posisi = is_null($request->posisi) ? $pegawai->posisi : $request->posisi;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('photo', $filename, 'public');
                $pegawai->file = $path;
            }

            $getIdPosisi = Careers::where('name', $request->posisi)->get();
            $pegawai->id_posisi = $getIdPosisi[0]->id;

            $pegawai->save();
            return response()->json([
                'message' => 'pegawai telah diupdate!',
                'idk' => $getIdPosisi[0]->id
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
            $filePath = $pegawai->file;

            // if (Storage::exists($filePath)) {
            //     Storage::delete($filePath);
            // }

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
