<?php

namespace App\Http\Repositories;

use App\Models\ActDefence;

class ActDefenceRepository
{
    public function get($id)
    {
        return ActDefence::find($id);
    }
    public function getByDefenceId($defenceId){
        return ActDefence::where('defence_id', $defenceId)->get();
    }
    public function create($name, $defenceId){
        return ActDefence::create([
            'name' => $name,
            'defence_id' => $defenceId
        ]);
    }
    public function checkUnique($name, $defenceId){
        return ActDefence::where([
            'name' => $name,
            'defence_id' => $defenceId
        ])->exists();
    }
    public function delete($id){
        return ActDefence::destroy($id);
    }
}
