<?php

namespace App\Http\Repositories;

use App\Models\Team;

class TeamRepository
{
    public function get($id)
    {
        return Team::find($id);
    }
    public function getAll(){
        return Team::all();
    }
    public function delete($id){
        return Team::destroy($id);
    }
}
