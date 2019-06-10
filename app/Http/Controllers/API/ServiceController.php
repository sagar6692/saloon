<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use App\Service;


class ServiceController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addservice(Request $request)
    {
                $validator = Validator::make($request->all(),[
                    // 'id'=>'required',
                    'name' =>'required',
                ]);
                if ($validator->fails()) { 
                    return response()->json(['message' => $validator->messages()->first(),'status' => 0, ]);            
                }
                $input = $request->all();
                $Service= Service::create($input);
                if($Service){
                $Service['name'] =  $Service->name;
                return response()->json(['Message'=>"Data Succesfully Stored",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                }
                
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showservice(Request $request,$id)
    {
                $showservice = DB::table('service')->where('id', $id)->get();   
                if($showservice){
                return response()->json(["showservice"=>$showservice ,'Message'=>"Data Succesfully Show",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                } 
    }

    public function listservice(Request $request)
    {

                $listservice = DB::table('service')
                ->get();
                return response( $listservice);
                if($listservice){
                return response()->json(["listservice"=>$listservice,'Message'=>"Data Succesfully Listed",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                } 
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateservice(Request $request)
    {
                $validator = Validator::make($request->all(),[
                'id' =>'required',
                'name' =>'required',
                ]);
                if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
                }
                $updateservice = Service::find($request['id']);
                if($updateservice){
                $updateservice->name = $request['name'];
                $updateservice->save();
                return response()->json(["updateservice"=>$updateservice ,'Message'=>"Data Succesfully Updated",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
                $deleteservice = Service::find($id);
                $deleteservice->status = 1;
                if($deleteservice){
                $deleteservice->save();
                return response()->json(['Message'=>"Data Succesfully Deleted",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                } 
    }
}