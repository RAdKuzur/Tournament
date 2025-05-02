<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public UserRepository $userRepository;
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function form()
    {
        return view('auth.form');
    }
    public function login(Request $request){
        $data = $request->validate([
            'username' => 'required|string|max:1000',
            'password' => 'required|string'
        ]);
        $user = $this->userRepository->getByUsername($data['username']);
        if ($user) {
            if (Auth::attempt(['name' => $data['username'], 'password' => $data['password']])) {
                return redirect()->route('tournament.index');
            }
        }
        return redirect()->route('auth.form');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('auth.form');
    }
    public function register(Request $request){
        $data = $request->validate([
            'username' => 'required|string|max:1000',
            'password' => 'required|string'
        ]);
        if (!$this->userRepository->checkUnique($data['username'])) {
            User::create([
                'name' => $data['username'],
                'password' => Hash::make($data['password'])
            ]);
        }
        return redirect()->route('auth.form');
    }
}
