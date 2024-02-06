<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuotesController extends Controller
{
    public function findAll(){
        $quotes = Quote::all();
        return response()->json($quotes);
    }

    public function addQuote(Request $request){
try {
        $this->validate($request, [
            'author' => 'required|string',
            'quote' => 'required',
        ]);
    } catch (ValidationException $exception) {
        return response()->json([
            'message' => 'Data yang diminta tidak lengkap',
            'errors' => $exception->validator->errors()
        ], 422);
    }

        $quote = new Quote();
        $quote->author = $request->author;
        $quote->quote = $request->quote;
        $quote->save();
        return response()->json([
            'message' => 'Quotes Ditambahkan!'
        ], 201);

    }

    public function findById($id){
        $quote = Quote::find($id);
        if(!empty($quote)){
            return response()->json($quote);
        }else{
            return response([
                'message' => 'quote tidak ada'
            ], 404);
        }
    }

    public function updateById(Request $request, $id){
        if(Quote::where('id', $id)->exists()){
            $quote = Quote::find($id);
            $quote->author = is_null($request->author) ? $quote->author : $request->author;
            $quote->quote = is_null($request->quote) ? $quote->quote : $request->quote;
            $quote->save();
            return response()->json([
                'message' => 'quote telah diupdate!'
            ], 200);
        }else{
            return response()->json([
                'message' => 'quote not found'
            ], 404);
        }
    }

    public function deleteById($id){
        $isExist = Quote::where('id', $id)->exists();
        if($isExist){
            $quote = Quote::find($id);
            $quote->delete();
            return response()->json([
                'message' => 'quote terhapus!'
            ],200);
        }else{
            return response()->json([
                'message' => 'quote not found'
            ], 404);
        }
    }

}
