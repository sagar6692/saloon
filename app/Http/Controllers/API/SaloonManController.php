<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use App\SaloonMan;


class SaloonManController extends Controller
{
   
    public function addsaloonman(Request $request)
    {
                $validator = Validator::make($request->all(),[
                'saloon_id'=>'required',
                'service_id' =>'required',
                ]);
                if ($validator->fails())
                { 
                    return response()->json(['message' => $validator->messages()->first(),'status' => 0, ]);           
                }
                $input = $request->all();
                $saloonman= SaloonMan::create($input);
                if($saloonman){
                $success['saloon_id'] =  $saloonman->saloon_id;
                $success['service_id'] =  $saloonman->service_id;
                // return response(  $success);
                return response()->json(["saloonman"=>$saloonman,'Message'=>"Data Succesfully Stored",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                }
        
    }

    public function listsaloonman(Request $request)
        {
                $ListSaloonMan = DB::table('saloon_man')
                ->join('registration_saloon', 'saloon_man.saloon_id', '=', 'registration_saloon.id')
                ->join('service', 'saloon_man.service_id', '=', 'service.id')
                ->get();
                if($ListSaloonMan){
                return response()->json(["ListSaloonMan"=>$ListSaloonMan,'Message'=>"Data Succesfully Listed",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                } 
        }
        public function destroy(Request $request, $id)
        {
            {
                $deletesaloonman = SaloonMan::find($id);
                $deletesaloonman->status = 1;
                if($deletesaloonman){
                $deletesaloonman->save();
                return response()->json(['Message'=>"Data Succesfully Deleted",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                } 
            }
        }
}
