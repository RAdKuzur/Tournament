<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Services\AccessService;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private AccessService $accessService;
    private UserRepository $userRepository;
    public function __construct(
        AccessService $accessService,
        UserRepository $userRepository
    )
    {
        $this->accessService = $accessService;
        $this->userRepository = $userRepository;
    }

    public function index() {
        if($this->accessService->checkAccess()){
            $users = $this->userRepository->getAll();
            return view('user.index', [
                'users' => $users,
            ]);
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function create() {
        if($this->accessService->checkAccess()){
            $roles = $this->userRepository->getRoles();
            return view('user.create', [
                'roles' => $roles,
            ]);
        }
        else {
            return redirect()->route('user.index');
        }
    }
    public function store(Request $request) {
        if($this->accessService->checkAccess()){
            $data = $request->validate([
                'name' => 'required | string | max:1000',
                'email' => 'required | email',
                'password' => 'required | string',
                'role' => 'required | integer',
            ]);
            if(!$this->userRepository->checkUnique($data['name'], $data['email'])) {
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]);
            }
            return redirect()->route('user.index');
        }
        else {
            return redirect()->route('user.index');
        }
    }
    public function show($id) {}
    public function edit($id) {
        if($this->accessService->checkAccess()){
            $user = $this->userRepository->get($id);
            $roles = $this->userRepository->getRoles();
            return view('user.edit', [
                'user' => $user,
                'roles' => $roles,
            ]);
        }
        else {
            return redirect()->route('user.index');
        }
    }
    public function update(Request $request, $id) {
        if($this->accessService->checkAccess()){
            $data = $request->validate([
                'name' => 'required | string | max:1000',
                'email' => 'required | email',
                'password' => 'nullable|string|max:1000',
                'role' => 'required | integer',
            ]);
            $user = $this->userRepository->get($id);
            $updateData = [
                'role' => $data['role'],
            ];
            if (!$this->userRepository->checkUnique($data['name'], $data['email'])){
                $updateData['name'] = $data['name'];
                $updateData['email'] = $data['email'];
            }
            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }
            $user->update($updateData);
            return redirect()->route('user.index');
        }
        else {
            return redirect()->route('user.index');
        }
    }
    public function destroy($id) {
        if($this->accessService->checkAccess()){
            $this->userRepository->delete($id);
            return redirect()->route('user.index');
        }
        else {
            return redirect()->route('user.index');
        }
    }
}
