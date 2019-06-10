<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use App\FavouriteSaloon;

class FavouriteSaloonController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addfavourite(Request $request)
    {

                $token = $request->header('Authorization');
                $user = User::where('api_token',$token)->first();
                if($user) {
                $validator = Validator::make($request->all(),[
              //  'user_id'=>'required',
                'saloon_id' =>'required',
                ]);
                if ($validator->fails()) { 
                return response()->json(['message' => $validator->messages()->first(),'status' => 0, ]);
                }
                $input = $request->all();
                $input['user_id'] = $user->id;

                $FavouriteSaloon= FavouriteSaloon::create($input);
                if($FavouriteSaloon){
            //  $FavouriteSaloon['name'] =  $FavouriteSaloon->name;
                return response()->json(['Message'=>"Data Succesfully Stored",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                }
            } else {
                return response()->json(['message' => 'User not found',  "status"=>"404"]);
                } 
                    
    }

    public function getfavourite(Request $request ,$user_id)
    {           
                return response()->json($user_id);

                $getfavourite = FavouriteSaloon::find($request['user_id']);
                if($getfavourite){
                $getfavourite = DB::table('favourite')
                ->join('registration_saloon', 'favourite.user_id', '=', 'registration_saloon.id')
                ->join('saloon_man', 'favourite.saloon_id', '=', 'saloon_man.id')
                ->where('favourite.user_id',$user_id)
                ->get();
                    
                return response()->json(["getfavourite"=>$getfavourite,'Message'=>"Data Succesfully Showed",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                }        
    }
 
}
