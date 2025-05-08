<?php

namespace App\Http\Repositories;

use App\Components\TournamentTypeDictionary;
use App\Models\Tournament;

class TournamentRepository
{
    public function getAll(){
        return Tournament::all();
    }
    public function get($id){
        return Tournament::find($id);
    }
    public function delete($id){
        return Tournament::destroy($id);
    }
    public function getTypes(){
        return (new TournamentTypeDictionary())->getList();
    }
    public function checkUnique($name, $beginDate, $finishDate){
        return Tournament::where('name' ,$name)->where('begin_date' ,$beginDate)->where('finish_date' ,$finishDate)->exists();
    }
    public function nextTour($id)
    {
        $tournament = $this->get($id);
        $tournament->current_tour = $tournament->current_tour + 1;
        return $tournament->save();
    }
}
