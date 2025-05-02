<?php

namespace App\Http\Repositories;
use App\Models\User;

class UserRepository
{
    public function getByUsername($username){
        return User::where('name', $username)->first();
    }
}
