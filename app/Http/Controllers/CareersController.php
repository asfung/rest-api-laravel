<?php

namespace App\Http\Controllers;

use App\Models\Careers;
use App\Models\CareersParent;
use App\Models\CareerTest;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    public function findAll(){
        return Careers::all();
    }

    // public function findById($id){
    //     $getId = Careers::where('id', $id)->get();
    //     return $getId;
    // }

    public function findAllParent(){
        return CareersParent::all();
    }

    // hanya testing 
    // public function getCareers()
    // {
    //     $careers = CareerTest::with('children')->whereNull('parent_id')->get();
    //     return response()->json(['items' => $careers]);
    // }

    // also testing
    public function getCareers()
    {
        $data = CareerTest::all();

        $tree = $this->buildTree($data);

        return response()->json($tree);
    }

    private function buildTree($data, $parentId = null)
    {
        $tree = [];
        foreach ($data as $item) {
            if ($item['parent_id'] == $parentId) {
                $children = $this->buildTree($data, $item['id']);

                if ($children) {
                    $item['children'] = $children;
                }

                $tree[] = $item;
            }
        }

        return $tree;
    }

    public function findById(Request $request){
        $queryId = $request->input('id_posisi');
        $execIdPosisi = Pegawai::where('id_posisi', $queryId)->get();
        return response()->json($execIdPosisi);
    }


    public function searchPegawai(Request $request){
        $searchNama = $request->input('nama');
        $searchPosisi = $request->input('id_posisi');

        // Build the query based on the provided search parameters
        $query = Pegawai::query();

        if (!empty($searchNama)) {
            $query->where('nama', 'like', "%$searchNama%");
        }

        if (!empty($searchPosisi)) {
            $query->where('id_posisi', $searchPosisi);
        }

        // Execute the query
        $pegawai = $query->get();

        if ($pegawai->isEmpty()) {
            return response()->json([
                'message' => 'Pegawai not found with the given search parameters',
            ], 404);
        }

        return response()->json($pegawai);
    }


}
