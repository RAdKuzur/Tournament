<?php

namespace App\Http\Services;

use App\Http\Repositories\TeamStudentRepository;
use App\Models\Team;
use App\Models\TeamStudent;

class TeamService
{
    private TeamStudentRepository $teamStudentRepository;
    public function __construct(
        TeamStudentRepository $teamStudentRepository
    )
    {
        $this->teamStudentRepository = $teamStudentRepository;
    }
    public function createTeamStudents($students, Team $team){
        foreach($students as $student){
            if(!$this->teamStudentRepository->checkUnique($team->id, $student)){
                if($this->teamStudentRepository->checkCorrectSchool($team, $student)){
                    TeamStudent::create([
                        'team_id' => $team->id,
                        'student_id' => $student
                    ]);
                }
            }
        }
    }
    public function updateTeamStudents($students, Team $team){
        //добавление участников
        foreach($students as $student){
            if(!$this->teamStudentRepository->checkUnique($team->id, $student)){
                if($this->teamStudentRepository->checkCorrectSchool($team, $student)){
                    TeamStudent::create([
                        'team_id' => $team->id,
                        'student_id' => $student
                    ]);
                }
            }
        }
        //удаление участников
        $existStudents = $this->teamStudentRepository->getParticipantsByTeamId($team->id);
        foreach($existStudents as $existStudent){
            if(!in_array($existStudent->student->id, $students)){
                $this->teamStudentRepository->delete($existStudent->student->id);
            }
        }
    }
}
