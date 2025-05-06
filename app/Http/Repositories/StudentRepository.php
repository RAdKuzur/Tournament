<?php

namespace App\Http\Repositories;

use App\Models\Student;

class StudentRepository
{
    public function getAll(){
        return Student::all();
    }

    public function getBySchoolId($id) {
        return Student::where('school_id', $id)->get();
    }
    public function get($id){
        return Student::find($id);
    }
    public function delete($id){
        return Student::destroy($id);
    }
    public function checkUnique($schoolId, $surname, $name, $patronymic = null)
    {
        $query = Student::where('name', $name)
            ->where('surname', $surname)
            ->where('school_id', $schoolId);

        if ($patronymic === null) {
            $query->whereNull('patronymic');
        } else {
            $query->where('patronymic', $patronymic);
        }

        return $query->exists();
    }
}
