<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class StorageController extends Controller
{
    public function getImage($filename){
        $path = storage_path('app/public/photo/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return response()->json([
            'debug' => base64_encode($file)
        ], 200);
        // return $response;

        // return response($file, 200)->header('Content-Type', $type);
    }
}
