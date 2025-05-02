<?php

namespace App\Http\Repositories;
use App\Models\Student;
use App\Models\Team;
use App\Models\TeamStudent;

class TeamStudentRepository
{
    public function getParticipantsByTeamId($teamId)
    {
        return TeamStudent::where('team_id', $teamId)->get();
    }
    public function checkUnique($teamId, $studentId){
        return TeamStudent::where('team_id', $teamId)->where('student_id', $studentId)->exists();
    }
    public function checkCorrectSchool(Team $team, $student)
    {
        return $team->school_id == Student::find($student)->school_id ? true : false;
    }
    public function delete($id)
    {
        return TeamStudent::destroy($id);
    }
}
