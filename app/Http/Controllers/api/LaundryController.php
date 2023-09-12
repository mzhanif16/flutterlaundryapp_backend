<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\laundry;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    function readAll(){
        
        $laundry = laundry::with('user','shop')->get();

        return response()->json([
            'message' => 'Berhasil Mengambil Data Laundry',
            'data' => $laundry,
        ], 200);
    }

    function whereUserId($id){
        $laundry = laundry::where('user_id','=', $id)
        ->with('shop','user')
        ->orderBy('created_at','desc')
        ->get();

        
        if(count($laundry)>0){
            return response()->json([
                'data'=>$laundry,
            ], 200);
        }else{
            return response()->json([
                'message'=>'Data tidak ditemukan',
                'data'=>$laundry,
            ],404);
        }
    }

    function claim(Request $request){

        $laundry = laundry::where([
            ['id','=',$request->id],
            ['claim_code','=',$request->claim_code]
        ])->first();
        
        if(!$laundry){
            return response()->json([
                'message' => 'not found',
            ], 404);
        }

        if($laundry->user_id !=0){
            return response()->json([
                'message'=>'Laundry has been claimed',
            ],400);
        }
        
        $laundry->user_id = $request->user_id;
        $updated = $laundry->save();
        
        if($updated){
            return response()->json([
                'data'=>$updated,
            ], 201);
        }else{
            return response()->json([
                'message'=>'cannot be updated',
            ], 500);
        }
    }
}
