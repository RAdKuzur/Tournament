<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'team_students');
    }

    public function teamStudents()
    {
        return $this->hasMany(TeamStudent::class);
    }

    public function gamesAsFirstTeam()
    {
        return $this->hasMany(Game::class, 'first_team_id');
    }

    public function gamesAsSecondTeam()
    {
        return $this->hasMany(Game::class, 'second_team_id');
    }
}
