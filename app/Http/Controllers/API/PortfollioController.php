<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use App\Portfollio;
use File;

class PortfollioController extends Controller
{
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addportfollio(Request $request)
    {            $token = $request ->header('Authorization'); 
                 $user = User::where('api_token',$token)->first();
                 if($user) {
                $validator = Validator::make($request->all(),[
                  //  'user_id'=>'required',
                    'photo' =>'required|mimes:jpeg,jpg,png',
                ]);
                if ($validator->fails()) { 
                return response()->json(['message' => $validator->messages()->first(),'status' => 0, ]);           
                }

            
                $input = $request->all();
                $input['user_id'] = $user->id;
            // $portfollio= Portfollio::create($input);
                $photo = $request->file('photo');
                $path = public_path() . '/uploads/';
                if (!File::exists($path)) 
                {
                File::makeDirectory($path);
                }
                $photo->move($path, $photo->getClientOriginalName());
                $input['photo'] = $path  . $photo->getClientOriginalName();

                $Portfollio= Portfollio::create($input,$photo);
                if($Portfollio)
                {
                $success['user_id'] =  $Portfollio->user_id;
                $success['photo'] =  $Portfollio->photo;
                // return response(  $success);
                return response()->json(["Portfollio"=>$Portfollio,'Message'=>"Data Succesfully Stored",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not store",'status' => '0']); 
                }
                return response()->json(['Message'=>"not found",'status' => '404']); 
            } 
 
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showportfollio(Request $request,$id)
    {
                $showportfollio = DB::table('portfolio')->where('id', $id)->get();   
                if($showportfollio)
                {
                return response()->json(["showportfollio"=>$showportfollio ,'Message'=>"Data Succesfully Show",'status' => '1']); 
                }else
                {
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
    public function updateportfollio(Request $request)
    {
                $validator = Validator::make($request->all(),[
                'user_id' =>'required',
                'photo' =>'required|mimes:jpg,png',
                ]);
                if ($validator->fails()) 
                { 
                    return response()->json(['message' => $validator->messages()->first(),'status' => 0, ]);            
                }
                $updateportfollio = Portfollio::find($request['id']);
                if ($request->has('photo')) 
                {
                $file = $request->file('photo');
                $path = public_path() . '/uploads/';
                $file->move($path, $file->getClientOriginalName());
                $updatesallondata['photo'] = $path  . $file->getClientOriginalName();      
                $updatesallondata->save();       
                } 
                if($updateportfollio)
                {
                $updateportfollio->photo = $request['photo'];
                $updateportfollio->save();
                return response()->json(["updateportfollio"=>$updateportfollio ,'Message'=>"Data Succesfully Updated",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                }
    }


    public function listportfollio(Request $request)
    {

                $listportfollio = DB::table('portfolio')
                ->join('registration_saloon', 'portfolio.user_id', '=', 'registration_saloon.id')
                ->get();
                if($listportfollio)
                {
                return response()->json(["listportfollio"=>$listportfollio,'Message'=>"Data Succesfully Listed",'status' => '1']); 
                }else
                {
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
                $deleteportfollio = Portfollio::find($id);
                $deleteportfollio->status = 1;
                if($deleteportfollio){
                $deleteportfollio->save();
                return response()->json(['Message'=>"Data Succesfully Deleted",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                } 
    }
}
