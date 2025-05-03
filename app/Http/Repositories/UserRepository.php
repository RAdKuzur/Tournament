<?php

namespace App\Http\Repositories;
use App\Components\RoleDictionary;
use App\Models\User;

class UserRepository
{
    public function get($id)
    {
        return User::find($id);
    }
    public function getAll(){
        return User::all();
    }
    public function delete($id)
    {
        return User::destroy($id);
    }
    public function getByUsername($username){
        return User::where('name', $username)->first();
    }
    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }
    public function checkUnique($username, $email){
        return User::where('name', $username)->where('email', $email)->exists();
    }
    public function getRoles(){
        return (new RoleDictionary())->getList();
    }
}
