<?php

namespace App\Http\Services;

use App\Http\Repositories\GameRepository;
use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TeamStudentParticipantRepository;
use App\Http\Repositories\TournamentRepository;
use RuntimeException;

class DrawCircleService
{
    private GameRepository $gameRepository;
    private TeamRepository $teamRepository;
    private TournamentRepository $tournamentRepository;
    private TeamStudentParticipantRepository $teamStudentParticipantRepository;
    public function __construct(
        GameRepository $gameRepository,
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        TeamStudentParticipantRepository $teamStudentParticipantRepository
    )
    {
        $this->gameRepository = $gameRepository;
        $this->teamRepository = $teamRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->teamStudentParticipantRepository = $teamStudentParticipantRepository;
    }

    public function drawCircle($tournamentId){
        $games = $this->gameRepository->getAllGamesFromTournament($tournamentId);
        $teams = $this->teamRepository->getAllbytournament($tournamentId);

        if(count($games) == 0 && count($teams) % 2 == 0){
            $teamIds = [];
            foreach ($teams as $team) {
                $teamIds[] = $team->id;
            }
            $teamCount = count($teams);
            $rounds = $teamCount - 1;
            $half = $teamCount / 2;
            for ($round = 0; $round < $rounds; $round++) {
                for ($i = 0; $i < $half; $i++) {
                    for ($i = 0; $i < $half; $i++) {
                        $home = $teamIds[$i];
                        $away = $teamIds[$teamCount - 1 - $i];
                        if ($home != "BYE" && $away != "BYE") {
                            $game = $this->gameRepository->create($home, $away, $tournamentId, $round + 1);
                            $teamHome = $this->teamRepository->get($home);
                            $this->teamStudentParticipantRepository->createParticipants($teamHome->teamStudents, $game->id);
                            $teamAway = $this->teamRepository->get($away);
                            $this->teamStudentParticipantRepository->createParticipants($teamAway->teamStudents, $game->id);
                        }
                    }
                }
                $firstTeam = $teamIds[0];
                $lastTeam = array_pop($teamIds);
                array_splice($teamIds, 1, 0, $lastTeam);
            }
        }
    }
    public function nextTour($id)
    {
        $tournament = $this->tournamentRepository->get($id);
        $teams = $this->teamRepository->getAllbytournament($id);
        if(count($teams) > $tournament->current_tour + 1){
            $this->tournamentRepository->nextTour($id);
        }
    }
}
