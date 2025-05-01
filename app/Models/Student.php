<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* @var $school School */
/* @var $teamStudents TeamStudent[] */

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'olymp_score',
        'school_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teamStudents()
    {
        return $this->hasMany(TeamStudent::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_students');
    }
    public function getFullFio()
    {
        return $this->surname . ' ' . $this->name . ' ' . $this->patronymic;
    }
}
