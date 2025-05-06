<?php

namespace App\Http\Services;

use App\Http\Repositories\GameRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TeamStudentRepository;
use App\Http\Repositories\TournamentRepository;
use App\Models\Game;

class DrawSwissService
{
    private StudentRepository $studentRepository;
    private TeamRepository $teamRepository;
    private TournamentRepository $tournamentRepository;
    private TeamStudentRepository $teamStudentRepository;
    private GameRepository $gameRepository;


    public function createFirstGame($tournamentId) {
        $tournament = $this->tournamentRepository->get($tournamentId);
        $teams = $tournament->team;
        $teamScore = [];
        foreach ($teams as $team) {
            $teamScore[$team->id] = $team->getOlympScore();
        }
        asort($teamScore);
        $sortedTeamIds = array_keys($teamScore);

        for ($i = 0; $i < count($teamScore) / 2; $i+=2) {
            $firstTeamId =  $sortedTeamIds[$i];
            $secondTeamId =  $sortedTeamIds[$i+1];

            $this->gameRepository->create($firstTeamId, $secondTeamId, $tournamentId, 1);
        }
    }

    public function createNewGame($tournamentId) {
        $tournament = $this->tournamentRepository->get($tournamentId);
        $teams = $tournament->team;
        //номер текущего тура
        $currentTour = $tournament->current_tour;

        $countWinTeams = [];
        //Определить кол-во побед для каждой команды
        $games = $tournament->games;
        foreach ($games as $game) {
            $firstTeamId = $game->firstTeam;
            $secondTeamId = $game->secondTeam;


            $firstTeamStudentIds = $firstTeamId->teamStudents->pluck('id');
            $secondTeamStudentIds = $secondTeamId->teamStudents->pluck('id');

            $firstTeamScore = $game->participants
                ->whereIn('team_student_id', $firstTeamStudentIds)
                ->sum('score');

            $secondTeamScore = $game->participants
                ->whereIn('team_student_id', $secondTeamStudentIds)
                ->sum('score');



            // Определяем победителя
            if ($firstTeamScore > $secondTeamScore) {
                $countWinTeams[$firstTeamId] += 1;
            } else {
                $countWinTeams[$secondTeamId] += 1;
            }


        }


        $scoreTeams = [];
        //Определить кол-во очков для каждой команды
        foreach ($teams as $team) {
            $games = Game::where('first_team_id', $team->id)->orWhere('second_team_id')->get();
            $scoreTeam = 0;
            foreach ($games as $game) {
                $teamStudent = $team->teamStudent;
                foreach ($teamStudent as $student) {


                    $score = TeamStudentRepository::where('team_student_id', $student->id)
                        ->andWhere('game_id', $game->id)->score;
                    $scoreTeam += $score;
                }
            }
            $scoreTeams[$team->id] = $scoreTeam;
        }

    }
}
