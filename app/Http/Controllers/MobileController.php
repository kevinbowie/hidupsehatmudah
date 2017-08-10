<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class MobileController extends Controller
{
    public function login(Request $req){
		$userdata = array(
            'username'    => $req['username'],
            'password' => $req['password']
        );

        if(Auth::attempt($userdata))
            return response()->json(['message'=> 'Login Success', 'code'=> '200','user'=>Auth::User()]);
        return response()->json(['message'=> 'Email and password does not match.', 'code'=> '401']);
    }
}
