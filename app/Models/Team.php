<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* @var $school School */
/* @var $students Student[] */
/* @var $teamStudents TeamStudent[] */
/* @var $tournament Tournament */
class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'school_id', 'tournament_id'];

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
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
    public function getOlympScore(){
        $participants = $this->teamStudents;
        $score = 0;
        foreach($participants as $participant){
            $score = $score + $participant->student->olymp_score;
        }
        return $score;
    }
    public function getTournamentScore()
    {
        $score = 0;
        foreach($this->teamStudents as $students){
            foreach($students->participants as $participant){
                $score = $score + $participant->score;
            }
        }
        return $score;
    }
}
