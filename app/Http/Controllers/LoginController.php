<?php

namespace App\Http\Controllers;

use App\Models\Category_Employer;
use App\Models\Client;
use App\Models\Employer;
use App\Models\Role;
use App\Models\Table;
use App\Models\User;
use Laravel\Passport\Client as OClient; 
use Illuminate\Database\QueryException;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{

    /**
     * Login function with email/username and password
     * @return error if not valid
     * @return token if valid
     */
    function Login(Request $request){


        // validation of api parametre
        $validate = Validator::make($request->all(),[
            'login'=>'required|string',
            'password'=>'String|required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'description' => $validate->errors()
            ],409);
        }

        $login = $this->getLogin($request['login'],$request['password']);

        //login the user with email and password 
        if(!Auth::attempt($login,$request['remember'])){
            return response()->json([
                'status' => 'error',
                'description' => 'email or password invalid'
            ],404);
        }
        
        //$Token = Auth::user()->createToken('authToken')->accessToken;
        $Token = $this->getTokenAndRefreshToken( $request['login'], $request['password'],$request);
        
        return $this->returnData(Auth::user()->role,$Token);
    }




    function Logout(Request $request){
        $request->user()
                ->token()
                ->delete();
        return response()->json([
            'status' => 'success',
        ],200);
    }



    /**
     * Register function 
     * @return error if not valid
     * @return token if valid
     */
    function register(Request $request){
        $Register = Validator::make($request->all(),[
            'name'=>'String|required',
            'email'=>'required|string|email',
            'user_name' => 'String|required',
            'password'=>'required|string'
        ]);

        if($Register->fails()){
            return response()->json([
                'status' => 'error',
                'description' => $Register->errors()
            ],409);
        }

        if(User::where('email',$request['email'])->get()->count()>0){
            return response()->json([
                'status' => 'error',
                'description' => 'this email already exist try to login'
            ],409);
        }

        if(User::where('user_name',$request['user_name'])->get()->count()>0){
            return response()->json([
                'status' => 'error',
                'description' => 'username already exist'
            ],409);
        }

        $Register['role'] = Role::where('name','client') -> first()-> id;
        $Register['password'] = bcrypt($Register['password']);

        try{
            $user = User::create($Register);
            try{
                $client = Client::create([
                    'name'=> $Register['name'],
                    'user' => $user->id,
                    'points' => 0,
                ]);
                Auth::login($user);
                $token = Auth::user()->createToken('authToken')->accessToken;

                return response()->json([
                    'status' => 'success',
                    'description'=>'Creation successfully',
                    'user' => $user,
                    'client' => $client,
                    'access_token' => $token
                ],201);
            }catch(QueryException $exception){
                return response()->json([
                    'status' => false,
                    'description' => 'Internal error'
                ],400);
                $user->delete;
            }
        }catch(QueryException $exception){
            return response()->json([
                'status' => false,
                'description' => 'Internal error'
            ],400);
        }
        
    }

    function getLogin($login,$password){
        //cheking the type of the login email or username
        $login_type = filter_var($login, FILTER_VALIDATE_EMAIL ) 
        ? 'email' 
        : 'username';

        if($login_type == 'username'){
            $email = User::where('user_name',$login) -> first() ?-> email;
            return ['email'=>$email , 'password' => $password] ;
        }else{
            return ['email'=>$login , 'password' => $password] ;
        }
    }

    function returnData($role,$Token){
        switch ($role) {
            case 2:
                $more = Client::find(User::find(Auth::user()->id)->getMoreDetails->id);
                return response()->json([
                    'status' => 'success',
                    'description' => 'Connection successfully',
                    'user'=>Auth::user(),
                    'client' => $more,
                    'token'=>$Token
                    ],200);
                break;
            case 3:
                $more = Table::find(User::find(Auth::user()->id)->getMoreDetails->id);
                return response()->json([
                    'status' => 'success',
                    'description' => 'Connection successfully',
                    'user'=>Auth::user(),
                    'table' => $more,
                    'token'=>$Token
                    ],200);
                break;
            case 4:
                $more = Employer::find(User::find(Auth::user()->id)->getMoreDetails->id);
                return response()->json([
                    'status' => 'success',
                    'description' => 'Connection successfully',
                    'user'=>Auth::user(),
                    'employer' => $more,
                    'category' => Category_Employer::find($more->category)->name,
                    'token'=>$Token
                    ],200);
                break;
            
            default:
                return response()->json([
                    'status' => 'success',
                    'description' => 'Connection successfully',
                    'user'=>Auth::user(),
                    'token'=>$Token
                ],200);
                break;
        }
    }

    public function getTokenAndRefreshToken( $email, $password,$request) { 
        
        $oClient = OClient::where("name","mocha-token")->first();
        $parm = [
            'grant_type' => 'password',
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'username' => $email,
            'password' => $password,
            'scope' => '*'
        ];
        $request->merge($parm);

        $request = Request::create('/oauth/token', "post" ,$parm);
        $request->headers->set("Content-Type","application/json");
        
        $response = Route::dispatch($request);
        
        
        $result = json_decode((string) $response->content(), true);
        return $result;
    }

    public function RefreshToken(Request $request) { 

        
        $oClient = OClient::where("name","mocha-token")->first();
        $parm = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh,
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'scope' => '*',
        ];
        $request->merge($parm);

        $request = Request::create('/oauth/token', "post" ,$parm);
        $request->headers->set("Content-Type","application/json");
        
        $response = Route::dispatch($request);
        
        
        $result = json_decode((string) $response->content(), true);
        return response()->json($result,200);
    }
}
