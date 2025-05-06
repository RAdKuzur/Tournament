<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Services\MailService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepository $userRepository;
    private MailService $mailService;
    public function __construct(
        UserRepository $userRepository,
        MailService $mailService
    )
    {
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }

    public function form()
    {
        if (Auth::check()) {
            return redirect()->route('tournament.index');
        }
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
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }
    public function resetPassword(Request $request){
        $data = $request->validate([
            'email' => 'required|string|email'
        ]);
        if ($user = $this->userRepository->getByEmail($data['email'])) {
            $url = $this->mailService->createTempLink("auth.new-password", 7200, $user->id);
            $this->mailService->sendNewPasswordLink($data['email'], $url);
        }
        return redirect()->route('auth.form');
    }
    public function newPassword($id)
    {
        if (!request()->hasValidSignature()) {
            abort(403);
        }
        return view('auth.new-password', ['id' => $id]);
    }
    public function updatePassword(Request $request, $id){
        $data = $request->validate([
            'password' => 'required|string'
        ]);
        $user = $this->userRepository->get($id);
        if($user) {
            $user->update([
                'password' => Hash::make($data['password'])
            ]);
        }
        return redirect()->route('auth.form');
    }
}
