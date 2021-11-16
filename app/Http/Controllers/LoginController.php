<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return response()->json($validate->errors(),202);
        }

        //cheking the type of the login email or username
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL ) 
        ? 'email' 
        : 'username';

        if($login_type == 'username'){
            $email = User::where('user_name',$request['login']) -> first() -> email;
            $login = ['email'=>$email , 'password' => $request['password']] ;
        }else{
            $login = ['email'=>$request['login'] , 'password' => $request['password']] ;
        }

        
        //login the user with email and password 
        if(!Auth::attempt($login,$request['remember'])){
            return response()->json([
                'status' => 'error',
                'description' => 'email or password invalid'
            ],404);
        }
        
        $Token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'status' => 'sucess',
            'user'=>Auth::user(),
            'access_token'=>$Token
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
            return response()->json($Register->errors(),202);
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

        $data = $request->all();
        $data['role'] = Role::where('name','client') -> first()-> id;
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $client = Client::create([
            'user' => $user->id,
            'points' => 0
        ]);

        $token = $user->createToken('api-application')->accessToken;

        return response()->json([
            'status' => 'sucess',
            'user' => $user,
            'more_data' => $client,
            'token' => $token
        ],201);
        

        
    }
}
