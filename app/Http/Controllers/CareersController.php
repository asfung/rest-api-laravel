<?php

namespace App\Http\Controllers;

use App\Models\Careers;
use App\Models\CareersParent;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    public function findAll(){
        return Careers::all();
    }

    public function findById($id){
        $getId = Careers::where('id', $id)->get();
        return $getId;
    }

    public function findAllParent(){
        return CareersParent::all();
    }

}
