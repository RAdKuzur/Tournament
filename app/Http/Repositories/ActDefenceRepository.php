<?php

namespace App\Http\Repositories;

use App\Models\ActDefence;

class ActDefenceRepository
{
    public function getByDefenceId($defenceId){
        return ActDefence::where('defence_id', $defenceId)->get();
    }
}
