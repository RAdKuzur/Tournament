<?php

namespace App\Http\Repositories;

use App\Models\Game;

class GameRepository
{
    public function create(array $data)
    {
        return Game::create($data);
    }

    public function getByTournamentAndTour(int $tournamentId, int $tour)
    {
        return Game::where('tournament_id', $tournamentId)
            ->where('tour', $tour)
            ->with(['firstTeam', 'secondTeam'])
            ->get();
    }

    public function updateResults(int $gameId, array $results)
    {
        return Game::where('id', $gameId)->update($results);
    }

    public function getGamesWithParticipants(int $tournamentId)
    {
        return Game::where('tournament_id', $tournamentId)
            ->with(['participants.teamStudent'])
            ->get();
    }
}
