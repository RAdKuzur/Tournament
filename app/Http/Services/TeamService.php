<?php

namespace App\Http\Services;

use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TeamStudentRepository;
use App\Models\Team;
use App\Models\TeamStudent;
use Illuminate\Support\Facades\DB;

class TeamService
{
    private TeamStudentRepository $teamStudentRepository;
    public function __construct(
        TeamStudentRepository $teamStudentRepository
    )
    {
        $this->teamStudentRepository = $teamStudentRepository;
    }

    public function createTeamWithStudents(string $name, int $schoolId, int $tournamentId, array $studentIds) {
        return DB::transaction(function () use ($name, $schoolId, $tournamentId, $studentIds) {
            $team = Team::create([
                    'name' => $name,
                    'school_id' => $schoolId,
                    'tournament_id' => $tournamentId,
                ]
            );

            $failedStudents =$this->checkStudentForTournament($tournamentId, $studentIds);
            if (!empty($failedStudents)) {
                DB::rollBack();
                return;
            }

            $this->createTeamStudents($studentIds, $team);
        });
    }

    private function checkStudentForTournament(int $tournamentId, array $studentIds) {
        $existingStudents = TeamStudent::whereIn('student_id', $studentIds)
            ->whereHas('team', function ($query) use ($tournamentId) {

            })
        ->pluck('student_id')
        ->toArray();

        return $existingStudents;
    }


    private function createTeamStudents($students, Team $team){
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
