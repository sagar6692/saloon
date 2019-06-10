<?php
namespace App\Http\Controllers\API;
//namespace App\Mail;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Input;
use Validator;
use Mail;
use Config;
use App\Review;
use App\Token;
use App\Availability;
use DB;

class UserController extends Controller 
{
  private $apiToken;
  public function __construct()
  {
    // Unique Token
          $this->apiToken = uniqid(base64_encode(str_random(60)));
  }
 public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request) {
      // Validations
      $rules = [
        //'email'=>'email',
        'mobile_no' => 'digits:10|numeric',
        'password'=>'required'
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        // Validation failed
        return response()->json(['message' => $validator->messages()->first(),'status' => 0, ]);
      } else {
     //   $email  = $request['email'];
        $mobile_no  = $request['mobile_no'];
        $password  = bcrypt($request->password);
     
       $mobile_nos  = User:: where('mobile_no', $mobile_no)
      ->get('mobile_no')
      ->first();

      //  $mobile_nos['mobile_no']

      // return response()->json($mobile_no);

      if($mobile_nos['mobile_no'] == $mobile_no ||  $mobile_nos['password'] == $password){
       // return response()->json($mobile_nos['mobile_no']);
      // return response()->json($mobile_nos);
      if($mobile_no != NULL){
        $user = User::where('mobile_no',$request->mobile_no)->first();
        if (!$user->is_mobile_verify) {
          return response()->json(['message' => 'Please check your  number for verify OTP', 'status' => '0', ]);
        }
        
        else{

          if($user) {
            // return response()->json($user );
            // Verify the password
            if( password_verify($request->password, $user->password) ) {
              // Update Token
              $postArray = ['api_token' => $this->apiToken];
              $login = User::where('mobile_no',$request->mobile_no)->update($postArray);
              
              if($login) {
                return response()->json([
                  'first_name'   => $user->first_name,
                  'mobile_no'    => $user->mobile_no,
                  'access_token' => $this->apiToken,
                  'Message' => 'Succesfully Login',
                  'status'=>'1'
                ]);
              }
            } else {
              return response()->json([ 'message' => 'Invalid Password','status' => 0 ]);
            }
          } else {
            return response()->json(['message' => 'User not found','status' => 404]);
          }
        }
      }
      if($mobile_no == NULL){
      // Fetch User
      $user = User::where('mobile_no',$request->mobile_no)->first();
      if (!$user->is_mobile_verify) {
        return response()->json([
          'message' => 'Please check your mobile number for verify OTP','status' => '0' ]);
      }
      else{

        if($user) {
         
          // Verify the password
          if( password_verify($request->password, $user->password) ) {
            // Update Token
            $postArray = ['api_token' => $this->apiToken];
            $login = User::where('mobile_no',$request->mobile_no)->update($postArray);
           
            if($login) {
              return response()->json([
                'first_name'   => $user->first_name,
                'mobile_no'    => $user->mobile_no,
                'access_token' => $this->apiToken,
                'Message' => 'Succesfully Login',
                'status'=>'1'
              ]);
            }
          } else {
            return response()->json([ 'message' => 'Invalid Password','status' => 0 ]);
          }
        } else {
          return response()->json(['message' => 'User not found','status' => 404 ]);
        }
      }
      
    }
      }else{
        return response()->json(['message' => 'Invalid username OR  password','status' => 0 ]);
      }
      
         
        
    }  
  }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
                        { 
                          $otp = mt_rand(1000,9999);
                            // Validations
                            $rules = [
                            'first_name' => 'required', 
                            'mobile_no' => 'required|digits:10|numeric', 
                              // 'email'   => 'required|email|unique:users', 
                            'email'     => 'email' ,
                            'password'  => 'required', 
                            'c_password' => 'required|same:password',
                            'user_type' => 'required' 
                            ];
                            $validator = Validator::make($request->all(), $rules);
                            if ($validator->fails()) {
                              // Validation failed
                              return response()->json(['message' => $validator->messages(),]);
                            } else {
                              $postArray = [
                            'user_type' =>$request->user_type,
                            'first_name'=> $request->first_name,
                            'email'     => $request->email,
                            'mobile_no' => $request->mobile_no,
                            'password'  => bcrypt($request->password),
                            'api_token' => $this->apiToken,
                            'otp'       => $otp
                              ];
                              $user = User::insert($postArray);
                              // return response()->json($postArray);
                              if($user) {
                                //$title = "Your OTP:";
                              Mail::raw($otp, function($message)
                            {
                                  $message->from('no-reply@site.com', "Saloon");
                                  $message->subject("Welcome to Saloon");
                                  $message->to(Input::get('email'));
                              // $message->to('patelsagar.mca@gmail.com');
                                // return response()->json(['Message' => $message , 'status' => 2 ]);
                               });
                              return response()->json([
                                  'first_name'   => $request->first_name,
                                  'mobile_no'    => $request->mobile_no,
                                  'email'        => $request->email,
                                  'access_token' => $this->apiToken,
                                  'Message'=>   'Please verify OTP to login',
                                  "status"=>"2"
                                ]);
                              }
                              else {
                                return response()->json([ 'message' => 'Registration failed, please try again.', "status"=>0 ]);
                              }
                            }
                          }
    }
    public function logout(Request $request)
    {
                $token = $request->header('Authorization');
                $user = User::where('api_token',$token)->first();
                if($user) {
                $postArray = ['api_token' => null];
                $logout = User::where('id',$user->id)->update($postArray);
                if($logout) {
                return response()->json(['message' => 'User Logged Out',  "status"=>"1" ]);}
                } else {
                return response()->json(['message' => 'User not found',  "status"=>"404"]);
                }     
    }  

    public function verifyuser(Request $request)
              {

                   $validator = Validator::make($request->all(),[
                  //  'id'=>'required',
                  'mobile_no' =>'required|digits:10|numeric',
                  'otp'=>'required|digits:4|numeric',
                  ]);
                  if ($validator->fails()) { 
                    return response()->json(['message' => $validator->messages()->first(),'status' => 0 ]);
            
                  } 
                  $mobile_no  = $request['mobile_no'];
                  $enteredOtp = $request['otp'];
               
                  $OTP  = DB::table('users')
                  ->where('mobile_no',$mobile_no)
                  ->get(['otp']);
                   if($OTP[0]->otp == $enteredOtp)
                  {
                  User::where('mobile_no', $mobile_no)
                  ->update(['is_email_verify' => 1]);
                  return response()->json(['Suceess', "Your account is verify please login" ,'status' => 1 ]); }
                 else{ 
                 return response()->json([  "Please verify code again",'status' => 0 ]);}

        }


        public function sendnewpassword(Request $request)
        {
                    $resetpassword = rand(1000,9999);
                    $rules = [
                      'email'     => 'required|email|' 
                  ];
                  $validator = Validator::make($request->all(), $rules);
                  if ($validator->fails()) {
                    // Validation failed
                    return response()->json(['message' => $validator->messages()->first(),'status' => 0 ]);
                  } else {
                    $postArray = ['otp_password' => $resetpassword];
                    {
                      $user = User::where('email',$request->email)->update($postArray);
                      if($user) {
                      Mail::raw($resetpassword, function($message)
                    {
                          $message->from('no-reply@site.com', "Saloon");
                          $message->subject("Welcome to Saloon");
                          $message->to(Input::get('email'));
                      // $message->to('patelsagar.mca@gmail.com');
                          
                    });
                    return response()->json(['email'=> $request->email,"status"=>"1"]); }
                  else {
                    return response()->json([ 'message' => 'Registration failed, please try again.',"status"=>"0" ]);
                 }
              }
           }
        }

        public function changepassword(Request $request)
        {

                          $validator = Validator::make($request->all(),[
                              //  'id'=>'required',
                              'email' =>'required',
                              'otp_password'=>'required|numeric',
                              'new_password'=>'required'
                                  
                          ]);
                          if ($validator->fails()) { 
                            return response()->json(['message' => $validator->messages()->first(),'status' => 0 ]);            
                          } 
                          $email  = $request['email'];
                          $otp_password = $request['otp_password'];
                          $new_password = bcrypt( $request['new_password']);
                    
                          $OTP  = DB::table('users')
                          ->where('email',$email)
                          ->get(['otp_password']);

                            if($OTP[0]->otp_password ==  $otp_password)
                            {
                           User::where('email', $email)
                          ->update(['password' => $new_password]);
                           return response()->json(['Suceess', "Your account is verify please login" ,'status' => 1]);
                            }
                          else{ return response()->json([ "Please verify code again" ,'status' => 0]);
                          }
        }
        public function searchsaloon(Request $request, $name)
          {
                        $searchsaloon = DB::table('registration_saloon')
                        ->where('name', $name)
                        ->get();  
                        if($searchsaloon ||$name  ){  
                        return response()->json(['searchsaloon'=>$searchsaloon,'Message'=>"Data Succesfully show",'status' => '1']); 
                        }else{
                        return response()->json(['Message'=>"not found",'status' => '404']); 
                        } 
        }
        public function nearybysaloon(Request $request, $pincode)
        {


        
                        $nearybysaloon = DB::table('registration_saloon')
                        ->where('pincode', $pincode)
                        ->get();  
                        if($nearybysaloon || $pincode  ){  
                        return response()->json(['nearybysaloon'=>$nearybysaloon,'Message'=>"Data Succesfully show",'status' => '1']); 
                        }else{
                        return response()->json(['Message'=>"not found",'status' => '404']); 
                      } 
         }
                public function addreview(Request $request)
                {
                      $token = $request->header('Authorization');
                      $user = User::where('api_token',$token)->first();
                      if($user) {
                        
          
                      $validator = Validator::make($request->all(),[
                          // 'id'=>'required',
                       // 'user_id' =>'required',
                        'saloon_id' =>'required',
                        'review_no' =>'required|numeric',
                        'comments' =>'required',
                      ]);
                      if ($validator->fails()) { 
                        return response()->json(['message' => $validator->messages()->first(),'status' => 0 ]);            
         
                      }
                      $input = $request->all();
                      $input['user_id'] = $user->id;
                      $Review= Review::create($input);
                      if($Review){
                      $Review['id'] =  $Review->id;
                      return response()->json(['Message'=>"Data Succesfully Stored",'status' => '1']); 
                      }else{
                        return response()->json(['Message'=>"not found",'status' => '404']); 
               }  
              }
              return response()->json(['Message'=>"Wrong Authorization",'status' => '404']);
                       
            
        }

        public function gettoken(Request $request)
        {
                    $validator = Validator::make($request->all(),[
                          //'id'=>'required',
                        // 'token_no' =>'required',
                          'user_id' =>'required',
                    ]);
                    if ($validator->fails()) { 
                      return response()->json(['message' => $validator->messages()->first(),'status' => 0 ]);            
            
                    }
                    $input = $request->all();
                    $Token= Token::create($input)->increment('token_no');
                    if($Token){
                    return response()->json([ 'token_no'=> $Token ,'Message'=>"Data Succesfully Stored",'status' => '1']); 
                    }else{
                      return response()->json(['Message'=>"not found",'status' => '404']); 
                 }
                
        }

        public function canceltoken(Request $request, $id)
          {
                  $canceltoken = Token::find($id);
                  $canceltoken->status = 1;
                  if($canceltoken){
                  $canceltoken->save();
                  return response()->json(['Message'=>"Data Succesfully Deleted",'status' => '1']); 
                  }else{
                  return response()->json(['Message'=>"not found",'status' => '404']); 
                  } 
        }

        public function availability(Request $request)
        {
                      $token = $request->header('Authorization');
                      $user = User::where('api_token',$token)->first();
                      if($user) {
                     $validator = Validator::make($request->all(),[
            
                  //  'user_id' =>'required',
                    'date' => 'date_format:Y-m-d H:i:s',
                    'reason' =>'required',
                ]);
                if ($validator->fails()) { 
                  return response()->json(['message' => $validator->messages()->first(),'status' => 0 ]);            
            
                }
                $input = $request->all();
                $input['user_id'] = $user->id;
                $availability= Availability::create($input);
                if($availability){
                $availability['id'] =  $availability->id;
                return response()->json(['Message'=>"Data Succesfully Stored",'status' => '1']); 
               }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
                }
              }
              return response()->json(['Message'=>"Wrong Authorization",'status' => '404']);
            
        }
        public function destroy(Request $request, $id)
        {
            {
                $deleteuser = User::find($id);
                $deleteuser->status = 1;
                if($deleteuser){
                 $deleteuser->save();
                 return response()->json(['Message'=>"Data Succesfully Deleted",'status' => '1']); 
                }else{
                return response()->json(['Message'=>"not found",'status' => '404']); 
              } 
          }
        }
      }


      

       
    