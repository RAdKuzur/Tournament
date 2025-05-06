<?php

namespace App\Http\Repositories;

use App\Models\Game;

class GameRepository
{
    public function create($first_team_id,$second_team_id,$tournament_id,$tour_id)
    {
        return Game::create([
            'first_team_id' => $first_team_id,
            'second_team_id' => $second_team_id,
           'tournament_id' => $tournament_id,
            'tour' => $tour_id,
        ]);
    }

    public function get($id)
    {
        return Game::find($id);
    }

    public function getByTournamentAndTour(int $tournamentId, int $tour)
    {
        return Game::where('tournament_id', $tournamentId)
            ->where('tour', $tour)
            ->with(['firstTeam', 'secondTeam'])
            ->get();
    }

    public function getAll(){
        return Game::all();
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

    public function delete($id){
        return Game::destroy($id);
    }
}
