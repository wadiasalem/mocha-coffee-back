<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ChangePasswordController extends Controller
{
    public function passwordResetProcess(UpdatePasswordRequest $request){
        return $this->updatePasswordRow($request)->count() > 0 ? $this->resetPassword($request) : $this->tokenNotFoundError();
      }
  
      // Verify if token is valid
      private function updatePasswordRow($request){
        return DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->passwordToken
        ]);
      }
  
      // Token not found response
      private function tokenNotFoundError() {
          return response()->json([
              'status'=>false,
            'description' => 'Either your email or token is wrong.'
          ],404);
      }
  
      // Reset password
      private function resetPassword($request) {
          // find email
          $userData = User::whereEmail($request->email)->first();
          // update password
          $userData->update([
            'password'=>Hash::make($request->password)
          ]);
          // remove verification data from db
          $this->updatePasswordRow($request)->delete();
  
          // reset password response
          return response()->json([
              'status'=>true,
            'description'=>'Password has been updated.'
          ],200);
      }    
}
