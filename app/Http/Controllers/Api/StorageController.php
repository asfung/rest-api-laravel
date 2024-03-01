<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    
        return $response;
    }

    public function getImageBase64(Request $request){
        if($request->has('filename')){
            $filename = $request->input('filename');
            $path = storage_path('app/public/' . $filename);

            if (!File::exists($path)) {
                abort(404);
            }
        
            $file = File::get($path);
            $type = File::mimeType($path);
        
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        
            // return response()->json([
            //     'debug' => base64_encode($file)
            //     // 'debug' => base64_encode($response)
            // ], 200);

        }
    }

}
