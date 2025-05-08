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
    public function getAllbytournament($tournamentId){
        return Team::where('tournament_id', $tournamentId)
            ->get();
    }
    public function delete($id){
        return Team::destroy($id);
    }
    public function checkUnique($name, $tournamentId){
        return Team::where('name' ,$name)->where('tournament_id', $tournamentId)->exists();
    }

}
