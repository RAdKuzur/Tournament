<?php

namespace App\Http\Services;

use App\Http\Repositories\GameRepository;
use App\Http\Repositories\TeamRepository;
use RuntimeException;

class DrawCircleService
{
    private GameRepository $gameRepository;
    private TeamRepository $teamRepository;
    public function __construct(
        GameRepository $gameRepository,
        TeamRepository $teamRepository
    )
    {
        $this->gameRepository = $gameRepository;
        $this->teamRepository = $teamRepository;
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
                            $this->gameRepository->create($home, $away, $tournamentId, $round + 1);
                        }
                    }
                }
            }
        }
    }
}
