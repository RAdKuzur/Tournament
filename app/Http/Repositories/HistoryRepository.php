<?php

namespace App\Http\Repositories;

use App\Models\History;

class HistoryRepository
{
    public function get($id){
        return History::find($id);
    }
    public function getAll(){
        return History::all();
    }
    public function create($id, $type, $score){
        return History::create([
            'defence_participant_id' => $id,
            'type' => $type,
            'score' => $score
        ]);
    }
}
