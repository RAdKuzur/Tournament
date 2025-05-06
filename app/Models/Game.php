<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* @var $firstTeam Team */
/* @var $secondTeam Team*/
/* @var $tournament Tournament */
/* @var $participants TeamStudentParticipant[] */
class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_team_id',
        'second_team_id',
        'tournament_id',
        'tour'
    ];

    public function firstTeam()
    {
        return $this->belongsTo(Team::class, 'first_team_id');
    }

    public function secondTeam()
    {
        return $this->belongsTo(Team::class, 'second_team_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participants()
    {
        return $this->hasMany(TeamStudentParticipant::class);
    }

    public function getGameWinner()
    {
        // Получаем ID участников команд
        $firstTeamStudentIds = $this->firstTeam->teamStudents->pluck('id');
        $secondTeamStudentIds = $this->secondTeam->teamStudents->pluck('id');

        // Суммируем очки через запросы к БД
        $firstTeamScore = $this->participants()
            ->whereIn('team_student_id', $firstTeamStudentIds)
            ->sum('score');

        $secondTeamScore = $this->participants()
            ->whereIn('team_student_id', $secondTeamStudentIds)
            ->sum('score');

        // Определяем победителя
        if ($firstTeamScore > $secondTeamScore) {
            return $this->first_team_id;
        }

        if ($secondTeamScore > $firstTeamScore) {
            return $this->second_team_id;
        }

        return null;
    }
}
