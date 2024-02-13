<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WilayahIndonesiaController extends Controller
{
    public function provinces()
    {
        return \Indonesia::allProvinces();
    }

    public function cities(Request $request)
    {
        return \Indonesia::findProvince($request->id, ['cities'])->cities->pluck('name', 'id');
    }

    public function districts(Request $request)
    {
        return \Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
    }

    public function villages(Request $request)
    {
        return \Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
    }
}


// namespace App\Http\Controllers;

// use Laravolt\Indonesia\IndonesiaService as Indonesia;
// use Illuminate\Http\Request;

// class WilayahIndonesiaController extends Controller
// {
//     public function provinces()
//     {
//         return Indonesia::allProvinces();
//     }

//     public function cities($id)
//     {
//         return Indonesia::findProvince($id, ['cities'])->cities->pluck('name', 'id');
//     }

//     public function districts($id)
//     {
//         return Indonesia::findCity($id, ['districts'])->districts->pluck('name', 'id');
//     }

//     public function villages($id)
//     {
//         return Indonesia::findDistrict($id, ['villages'])->villages->pluck('name', 'id');
//     }
// }
