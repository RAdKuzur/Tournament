<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function form()
    {
        return view('auth.form');
    }
    public function login(Request $request){
        return redirect()->route('tournament.index');
    }
    public function logout(Request $request){

    }

}
