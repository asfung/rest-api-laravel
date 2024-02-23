<?php

namespace App\Http\Controllers\Api;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Careers;
use App\Models\CareerTest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\Foreach_;

class PegawaiController extends Controller
{


    public function findAll(Request $request){
        // $perPage = $request->query('pagePage', 3); 
        // $pegawai = Pegawai::paginate($perPage);
    
        // return response()->json($pegawai);

        $perPage = $request->query('pagePage', 5);  

        $pegawai = Pegawai::paginate($perPage);

        $response = [
            'current_page' => $pegawai->currentPage(),
            'total_items' => $pegawai->total(),
            'data' => $pegawai->items(),
        ];

        return response()->json($response);
    }

    public function forcingAll(){
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

        // $getIdPosisi = Careers::where('name', $request->posisi)->get();
        $getIdPosisi = CareerTest::where('name', $request->posisi)->get();
        foreach($getIdPosisi as $value){
            $pegawai->id_posisi = $value->id_tree;
            $pegawai->career_code = $value->career_code;
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

            // $getIdPosisi = Careers::where('name', $request->posisi)->get();
            $getIdPosisi = CareerTest::where('name', $request->posisi)->get();
            $pegawai->id_posisi = $getIdPosisi[0]->id_tree;
            $pegawai->career_code = $getIdPosisi[0]->career_code;

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

    public function search(Request $request){
        $searchNama = $request->input('nama');
        
        if (empty($searchNama)) {
            return response()->json([
                'message' => 'Search query is empty',
            ], 400);
        }

        $pegawai = Pegawai::where('nama', 'like', "%$searchNama%")->get();

        if ($pegawai->isEmpty()) {
            return response()->json([
                'message' => 'Pegawai not found with the given search query',
            ], 404);
        }

        return response()->json($pegawai);
    }

    public function searchPegawai(Request $request){
        $searchNama = $request->input('nama');
        $searchPosisi = $request->input('id_posisi');
        $perPage = $request->input('per_page', 5);

        $query = Pegawai::query();

        if (!empty($searchNama)) {
            $query->where('nama', 'like', "%$searchNama%");
        }

        // if (!empty($searchPosisi)) {
        //     $query->where('id_posisi', $searchPosisi);
        // }
        if (!empty($searchPosisi)) {
            // if (strlen($searchPosisi) === 1) {
            //     // jika 1, dengan career code yang sama
            //     $careerTestItems = CareerTest::where('parent_id', $searchPosisi)->pluck('career_code');
            //     $query->whereIn('career_code', $careerTestItems);
            // } else {
            //     $query->where('id_posisi', $searchPosisi);
            // }
            $query->where('id_posisi', 'like', "$searchPosisi%");
        }

        // $pegawai = $query->get();
        $pegawai = $query->paginate($perPage);

        if ($pegawai->isEmpty()) {
            return response()->json([
                'message' => 'Pegawai not found with the given search parameters',
                'debug' => dd($pegawai)
            ], 404);
        }

        return response()->json($pegawai);
    }


    // mainin export import laravel excel here


}


/*

        $request->validate([
            'nama' => 'nullable',
            'posisi' => 'nullable'
        ]);

        $searchNama = $request->input('nama');
        $searchPosisi = $request->input('id_posisi');

        $pegawaiQuery = Pegawai::query();
        $posisiQuery = CareerTest::query();

        if (!empty($searchNama)) {
            $pegawaiQuery->where('nama', 'like', "%$searchNama%");
        }

        if (!empty($searchPosisi)) {
            $posisiQuery->where('id', $searchPosisi);
        }

        $pegawai = $pegawaiQuery->get();
        $posisi = $posisiQuery->get();

        if ($pegawai->isEmpty()) {
            return response()->json([
                'message' => 'Pegawai not found with the given search parameters',
            ], 404);
        }

        return response()->json([
            'pegawai' => $pegawai,
            'posisi' => $posisi
        ]);


*/
