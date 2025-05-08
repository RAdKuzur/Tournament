<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* @var $student Student */
/* @var $team Team */
/* @var $participants TeamStudentParticipant[] */
class TeamStudent extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'team_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function participants()
    {
        return $this->hasMany(TeamStudentParticipant::class);
    }
    public function getScores()
    {
        $score = 0;
        foreach($this->participants as $participant) {
            $score += $participant->score;
        }
        return $score;
    }
}
