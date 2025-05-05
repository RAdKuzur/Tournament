<?php

namespace App\Http\Repositories;

use App\Components\DefenceTypeDictionary;
use App\Models\Defence;

class DefenceRepository
{
    public function getAll(){
        return Defence::all();
    }
    public function get($id){
        return Defence::find($id);
    }
    public function delete($id){
        return Defence::destroy($id);
    }
    public function getTypes(){
        return (new DefenceTypeDictionary())->getList();
    }
    public function checkUnique($name, $date, $type)
    {
        return Defence::where([
            ['name', '=', $name],
            ['date', '=', $date],
            ['type', '=', $type]
        ])->exists();
    }
}
