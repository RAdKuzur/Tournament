<?php

namespace App\Http\Services;

use App\Components\RoleDictionary;
use App\Helpers\BaseHelper;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AccessService
{
    public function checkAccess(){
        $user = Auth::user();
        if ($user) {
            if (BaseHelper::isPrefixOfAny(request()->getPathInfo(), RoleDictionary::getAvailableUrls($user->role))) {
                return true;
            }
        }
        return false;
    }
}
