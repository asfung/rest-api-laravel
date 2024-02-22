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
        return CareerTest::all();
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
                $children = $this->buildTree($data, $item['id_tree']);

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


    // public function searchPegawai(Request $request){
    //     $searchNama = $request->input('nama');
    //     $searchPosisi = $request->input('id_posisi');

    //     // Build the query based on the provided search parameters
    //     $query = Pegawai::query();

    //     if (!empty($searchNama)) {
    //         $query->where('nama', 'like', "%$searchNama%");
    //     }
        

    //     // if (!empty($searchPosisi)) {
    //     //     $query->where('id_posisi', $searchPosisi);
    //     // }
    //     if (!empty($searchPosisi)) {
    //         if (strlen($searchPosisi) === 1) {
    //             // If id_posisi has length 1, select from CareerTest where parent_id is $searchPosisi
    //             $careerTestItems = CareerTest::where('parent_id', $searchPosisi)->pluck('career_code');
    //             $query->whereIn('career_code', $careerTestItems);
    //         }elseif(strlen($searchPosisi) === 2 ){
    //             $isParentIdHasTwoLength = CareerTest::where('id', $searchPosisi)->first();

    //             if ($isParentIdHasTwoLength && $isParentIdHasTwoLength->tree_lvl === '2') {
    //                 // If the id_posisi with length 2 has tree_lvl 3, retrieve all records with tree_lvl 2 and 3
    //                 $query->where(function ($subquery) use ($isParentIdHasTwoLength, $searchPosisi) {
    //                     $subquery->where('id_posisi', $isParentIdHasTwoLength->parent_id)
    //                         ->orWhere('id_posisi', $searchPosisi);
    //                 });
    //             } else {
    //                 // If the id_posisi with length 2 does not have tree_lvl 3, simply filter by id_posisi
    //                 $query->where('id_posisi', $searchPosisi);
    //             }

    //         } else {
    //             $query->where('id_posisi', $searchPosisi);
    //         }
    //     }

    //     // Execute the query
    //     $pegawai = $query->get();

    //     if ($pegawai->isEmpty()) {
    //         return response()->json([
    //             'message' => 'Pegawai not found with the given search parameters',
    //         ], 404);
    //     }

    //     return response()->json($pegawai);
    // }

    public function searchPegawai(Request $request){
        $searchNama = $request->input('nama');
        $searchPosisi = $request->input('id_posisi');

        $query = Pegawai::query();

        if (!empty($searchNama)) {
            $query->where('nama', 'like', "%$searchNama%");
        }

        if (!empty($searchPosisi)) {
            // if (strlen($searchPosisi) === 1) {
            //     // If id_posisi has length 1, select from CareerTest where parent_id is $searchPosisi
            //     $careerTestItems = CareerTest::where('parent_id', $searchPosisi)->pluck('career_code');
            //     $query->whereIn('career_code', $careerTestItems);
            // } elseif (strlen($searchPosisi) === 2) {
            //     $isParentIdHasTwoLength = CareerTest::where('id', $searchPosisi)->first();

            //     if ($isParentIdHasTwoLength && $isParentIdHasTwoLength->tree_lvl === '2') {
            //         // If the id_posisi with length 2 has tree_lvl 3, retrieve all records with tree_lvl 2 and 3
            //         $query->where(function ($subquery) use ($isParentIdHasTwoLength, $searchPosisi) {
            //             $subquery->where('id_posisi', $isParentIdHasTwoLength->parent_id)
            //                 ->orWhere('id_posisi', $searchPosisi);
            //         });
            //     } else {
            //         // If the id_posisi with length 2 does not have tree_lvl 3, simply filter by id_posisi
            //         $query->where('id_posisi', $searchPosisi);
            //     }

            // } else {
            //     $query->where('id_posisi', $searchPosisi);
            // }
            $query->where('id_posisi', 'like', "$searchPosisi%");
        }

        $perPage = $request->input('per_page', 10);
        $pegawai = $query->paginate($perPage);

        if ($pegawai->isEmpty()) {
            return response()->json([
                'message' => 'Pegawai not found with the given search parameters',
            ], 404);
        }

        return response()->json($pegawai);
    }

    public function addCareer(Request $request){
        $name = strtoupper($request->input('name'));
        $id = $request->input('id_tree');
        $current_idTree = null;
        $current_idTree_forParent = null;

        // strtoupper($name);

        // $isExist = CareerTest::where('name', $name)->get();
        $isExist = CareerTest::all();
        foreach($isExist as $exist){
            if($exist->name === $name){
                return response()->json([
                    'message' => 'name is already taken'
                ], 404);
            }
        }

        // for parent field only
        $forParent = CareerTest::where('parent_id', null)->get();
        foreach($forParent as $parent){
            $current_idTree_forParent = $parent->id;
        }

        if($id === null){
            return response()->json([
                'message' => $name . ' akan dijadikan parent',
                'current id_tree' => $current_idTree_forParent,
                'debug' => $forParent,
            ], 200);
        }



        $requirementField = CareerTest::where('id_tree', $id)->first();
        $requirementField_name = $requirementField->name;
        $requirementField_parentId = $requirementField->parent_id;
        $requirementField_career_code = $requirementField->career_code;
        $requirementField_idTree = $requirementField->id_tree;
        $requirementField_treeLvl = $requirementField->tree_lvl;


        $treeLvl_toInt = (int) $requirementField_treeLvl;
        $idTree_toInt = (int) $requirementField_idTree;
        $increment_treelvl = ++$treeLvl_toInt;
        $current_career_idTree = CareerTest::where('id_tree', 'like', "$id%")->where('tree_lvl', $increment_treelvl)->get();

        // get current number
        foreach($current_career_idTree as $career){
            $current_idTree = $career->id_tree;
        }

        //increment the id_tree
        $nextNumber = str_pad((int) $current_idTree + 1, strlen($current_idTree), '0', STR_PAD_LEFT);
        $id_tree_currentIncrement = sprintf('%s', $nextNumber);
        

        // we need
        // career code is requirementField_career_code
        // $name to be name to CareerTest
        // $id is to be parent_id to CareerTest
        // $increment_treeLvl to be tree_lvl to CareerTest or $treeLvl_toInt
        // id_tree from CareerTest will be $current_idTree + 1

        // CareerTest::create([
        //     'career_code' => $requirementField_career_code,
        //     'name' => $name,
        //     'parent_id' => $id,
        //     'tree_lvl' => $treeLvl_toInt,
        //     'id_tree' => $id_tree_currentIncrement
        // ]);

        return response()->json([
            'debug' => $requirementField,
            'maka' => [
                'tipe tree_lvl ' => gettype($treeLvl_toInt),
                'tree level sebelum ' . $treeLvl_toInt => 'jadi ' . $increment_treelvl,
                'current id_tree of ' . $requirementField_idTree => $current_idTree,
                'new id tree' =>  $id_tree_currentIncrement,
                // 'saat ini ' . $current_idTree => 'yang baru ' . ++$current_idTree, it will be +2 if before has increment too
                'parent id' => $id,
                'career code' => $requirementField_career_code,
                'nama' => $name
            ]
            // 'message' => 'berhasil menambahkan ' . $name

        ], 201);
    }



    // testing code

    public function getDescendants($name) {
        // Find the CareerTest record with the given name
        $parent = CareerTest::where('name', $name)->first();
    
        if (!$parent) {
            // Handle the case where the parent is not found
            return response()->json([
                'message' => 'Parent not found with the given name',
            ], 404);
        }
    
        // Fetch descendants recursively
        $descendants = $this->fetchDescendants($parent->id);
    
        // Return the result
        return response()->json($descendants);
    }
    
    protected function fetchDescendants($parentId) {
        // Recursive function to fetch descendants
        $children = CareerTest::where('parent_id', $parentId)->get();
        $descendants = [];
    
        foreach ($children as $child) {
            $childData = [
                'id' => $child->id,
                'career_code' => $child->career_code,
                'name' => $child->name,
                'children' => $this->fetchDescendants($child->id),
            ];
    
            $descendants[] = $childData;
        }
    
        return $descendants;
    }
    
    public function getSoftwareEngineerWithChildren($id)
    {
        // Find the Software Engineer with ID $id
        $softwareEngineer = CareerTest::with('children')->find($id);

        if (!$softwareEngineer) {
            return response()->json(['message' => 'Software Engineer not found'], 404);
        }

        return response()->json($softwareEngineer);
    }

    public function searchPegawaiPosisi(Request $request){
        // Your existing code to get $pegawai...
        $pegawai = $request->input('id_posisi');
    
        $pegawaiWithChildren = $pegawai->map(function ($pegawaiItem) {
            return $this->mapPegawaiWithChildren($pegawaiItem);
        });
    
        // Return the modified response
        return response()->json($pegawaiWithChildren);
    }
    
    protected function mapPegawaiWithChildren($pegawaiItem) {
        $children = CareerTest::where('parent_id', $pegawaiItem->id)->where('tree_lvl', '3')->get();
    
        $mappedItem = $pegawaiItem->toArray();
    
        if (!$children->isEmpty()) {
            // Recursively map children with tree_lvl 3
            $mappedChildren = $children->map(function ($child) {
                return $this->mapPegawaiWithChildren($child);
            });
    
            $mappedItem['children'] = $mappedChildren->toArray();
        }
    
        return $mappedItem;
    }
    

}
