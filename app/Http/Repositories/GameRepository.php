<?php

namespace App\Http\Repositories;

use App\Models\Game;

class GameRepository
{
    public function create($first_team_id,$second_team_id,$tournament_id,$tour)
    {
        return Game::create([
            'first_team_id' => $first_team_id,
            'second_team_id' => $second_team_id,
           'tournament_id' => $tournament_id,
            'tour' => $tour,
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

    /**
     * Получает текущий тур турнира
     */
    public function getCurrentTour(int $tournamentId): int
    {
        $lastGame = Game::where('tournament_id', $tournamentId)
            ->orderBy('tour', 'desc')
            ->first();

        return $lastGame ? $lastGame->tour : 0;
    }

    public function getAll(){
        return Game::all();
    }

    public function updateScore(int $gameId, int $teamId, int $newScore): bool
    {
        $game = Game::findOrFail($gameId);

        // Проверяем, что переданный teamId принадлежит этой игре
        if ($game->first_team_id !== $teamId && $game->second_team_id !== $teamId) {
            throw new \Exception("Команда $teamId не участвует в этой игре");
        }

        // Обновляем счёт через участников (TeamStudentParticipant)
        $teamStudents = TeamStudent::where('team_id', $teamId)->pluck('id');

        // Если нужно обновить всех участников команды одинаково:
        TeamStudentParticipant::where('game_id', $gameId)
            ->whereIn('team_student_id', $teamStudents)
            ->update(['score' => $newScore]);

        // Пересчитываем победителя игры
        $game->determineWinner();

        return true;
    }

    public function getAllGamesFromTournament(int $tournamentId)
    {
        return Game::where('tournament_id', $tournamentId)
            ->get();
    }

    public function delete($id){
        return Game::destroy($id);
    }
}
