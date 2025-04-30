<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* @var $game Game */
/* @var $teamStudent TeamStudent */
class TeamStudentParticipant extends Model
{
    use HasFactory;
    protected $fillable = [
        'game_id',
        'team_student_id',
        'score'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function teamStudent()
    {
        return $this->belongsTo(TeamStudent::class);
    }
}
