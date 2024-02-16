<?php

namespace App\Http\Controllers;

use App\Models\Agama;

class AgamaController extends Controller
{
    public function findAll(){
        return Agama::all();
    }

    public function findById($id){
        $agama = Agama::where('id', $id)->get();
        return $agama;
    }

}
