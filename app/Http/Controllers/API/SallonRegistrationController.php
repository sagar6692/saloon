<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use File;
use App\RegistrationSaloon;
use Illuminate\Support\Facades\Storage;


class SallonRegistrationController extends Controller
{
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
                    $validator = Validator::make($request->all(),[
                        // 'id'=>'required',
                        'name' =>'required',
                        'address' =>'required',
                        //  'longitude' =>'required',
                        //  'latitude' =>'required',
                        'saloon_number' =>'required',
                        'contact_number' =>'required| min:10 | numeric',
                        'email' =>'email',
                        'no_of_seats' =>'numeric',
                        'type' =>'required',
                        'logo' =>'mimes:jpeg,jpg,png',
                        'banner1' =>'mimes:jpeg,jpg,png',
                        'banner2' =>'mimes:jpeg,jpg,png',
                        'banner3' =>'mimes:jpeg,jpg,png',
                        'contact_person_name' =>'required'
                    ]);
                    
                    if ($validator->fails()) { 
                        return response()->json(['message' => $validator->messages()->first(),'status' => 0, ]);;            
                    }
                    
                    // $id  = $request['id'];
                    $name = $request['name'];

                    $input = $request->all();

                    $Sallonregistration = RegistrationSaloon::create($input);
                    $logo = $request->file('logo');
                    $banner1 = $request->file('banner1');
                    $banner2 = $request->file('banner2');
                    $banner3 = $request->file('banner3');
                    
                    $path = public_path() . '/uploads/' . $name . '/';
                    if (!File::exists($path)) {
                        File::makeDirectory($path);
                    }
                    
                    $logo->move($path, $logo->getClientOriginalName());
                    $input['logo'] = $path  . $logo->getClientOriginalName();

                    $banner1->move($path, $banner1->getClientOriginalName());
                    $input['banner1'] = $path  . $banner1->getClientOriginalName();

                    $banner2->move($path, $banner2->getClientOriginalName());
                    $input['banner2'] = $path  . $banner2->getClientOriginalName();

                    $banner3->move($path, $banner3->getClientOriginalName());
                    $input['banner3'] = $path  . $banner3->getClientOriginalName();

                    $Sallon= RegistrationSaloon::create($input,$logo,$banner1, $banner2, $banner3);
                    if($Sallon){
                    $success['id'] =  $Sallon->id;
                    $success['banner1'] =  $Sallon->banner1;
                    // return response(  $success);
                    return response()->json(["Document"=>$Sallon,'Message'=>"Data Succesfully Stored",'status' => '1']); 
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
    public function updatesaloon(Request $request)
    {
                   $validator = Validator::make($request->all(),[
                    'id'=>'required',
                    'name' =>'required',
                    'address' =>'required',
                    //  'longitude' =>'required',
                    //  'latitude' =>'required',
                    'saloon_number' =>'required',
                    'contact_number' =>'required| min:10 | numeric',
                    'email' =>'email',
                    'no_of_seats' =>'numeric',
                    'type' =>'required',
                    'logo' =>'mimes:jpeg,jpg,png',
                    'banner1' =>'mimes:jpeg,jpg,png',
                    'banner2' =>'mimes:jpeg,jpg,png',
                    'banner3' =>'mimes:jpeg,jpg,png',
                    'contact_person_name' =>'required'
                    ]);
                    if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], 401);            
                    }
                
                    $user_id = $request->input('id');

                    $updatesallondata = RegistrationSaloon::find($user_id);

                    $updatesallondata->name = $request['name'];
                    $updatesallondata->address = $request['address'];
                    $updatesallondata->saloon_number = $request['saloon_number'];
                    $updatesallondata->contact_number = $request['contact_number'];
                    $updatesallondata->email = $request['email'];
                    $updatesallondata->no_of_seats = $request['no_of_seats'];
                    $updatesallondata->type = $request['type'];
                //  $updatesallondata->logo = $request['logo'];
                    // $updatesallondata->banner1 = $request['banner1'];
                //  $updatesallondata->banner2 = $request['banner2'];
                //   $updatesallondata->banner3 = $request['banner3'];
                    $updatesallondata->contact_person_name = $request['contact_person_name'];

                    $updatesallondata->save();

                if ($request->has('banner1')) {
                    $file = $request->file('banner1');
                    $path = public_path() . '/uploads/';
                    $file->move($path, $file->getClientOriginalName());
                    $updatesallondata['banner1'] = $path  . $file->getClientOriginalName();      
                    $updatesallondata->save();       
                } 
                if ($request->has('banner2')) {
                    $file = $request->file('banner2');
                    $path = public_path() . '/uploads/';
                    $file->move($path, $file->getClientOriginalName());
                    $updatesallondata['banner2'] = $path  . $file->getClientOriginalName();      
                    $updatesallondata->save();       
                }
                if ($request->has('banner3')) {
                    $file = $request->file('banner3');
                    $path = public_path() . '/uploads/';
                    $file->move($path, $file->getClientOriginalName());
                    $updatesallondata['banner3'] = $path  . $file->getClientOriginalName();      
                    $updatesallondata->save();       
                }
                if ($request->has('logo')) {
                    $file = $request->file('logo');
                    $path = public_path() . '/uploads/';
                    $file->move($path, $file->getClientOriginalName());
                    $updatesallondata['logo'] = $path  . $file->getClientOriginalName();      
                    $updatesallondata->save();       
                }

                if($updatesallondata){
                    $updatesallondata->name = $request['name'];
                    $updatesallondata->save();
                    
                    return response()->json(["updateinfo"=>$updatesallondata,'Message'=>"Data Succesfully Updated",'status' => '1']); 
                    }else{
                    return response()->json(['Message'=>"not found",'status' => '404']); 
                    }
      }

      public function listsaloon(Request $request)
      {
                    $listsaloon = DB::table('registration_saloon')
                    ->get();
                    if($listsaloon){
                    return response()->json(["listsaloon"=>$listsaloon,'Message'=>"Data Succesfully Listed",'status' => '1']); 
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
        {
                    $deletesaloon = RegistrationSaloon::find($id);
                    $deletesaloon->status = 1;
                    if($deletesaloon){
                    $deletesaloon->save();
                    return response()->json(['Message'=>"Data Succesfully Deleted",'status' => '1']); 
                    }else{
                    return response()->json(['Message'=>"not found",'status' => '404']); 
                    } 
        }
    }

}
