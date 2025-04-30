<?php

namespace App\Http\Repositories;

use App\Models\School;

class SchoolRepository
{
    public function getAll(){
        return School::all();
    }
    public function get($id){
        return School::find($id);
    }
    public function checkUnique($name){
        return School::where('name', $name)->exists();
    }
    public function delete($id){
        return School::destroy($id);
    }
}
