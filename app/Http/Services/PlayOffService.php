<?php

namespace App\Http\Services;


use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TeamStudentRepository;
use App\Http\Repositories\TournamentRepository;
use App\Http\Repositories\GameRepository;

class PlayOffService
{
    private TeamRepository $teamRepository;
    private TournamentRepository $tournamentRepository;
    private TeamStudentRepository $teamStudentRepository;
    private GameRepository $gameRepository;

    public function __construct(
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        TeamStudentRepository $teamStudentRepository,
        GameRepository $gameRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->teamStudentRepository = $teamStudentRepository;
        $this->gameRepository = $gameRepository;
    }

    /**
     * Генерирует пары для следующего тура плей-офф
     */
    public function generateNextPlayOffRound(int $tournamentId): array
    {
        // Получаем текущий тур
        $currentTour = $this->getCurrentTour($tournamentId);
        $nextTour = $currentTour + 1;

        // Получаем победителей предыдущего тура
        $winners = $this->getWinnersFromTour($tournamentId, $currentTour);

        if (count($winners) < 2) {
            throw new \Exception('Недостаточно команд для формирования следующего тура');
        }

        // Формируем пары для следующего тура
        $pairs = $this->pairTeams($winners);

        // Создаем игры для следующего тура
        foreach ($pairs as $pair) {
            $this->gameRepository->create([
                'first_team_id' => $pair[0],
                'second_team_id' => $pair[1],
                'tournament_id' => $tournamentId,
                'tour' => $nextTour
            ]);
        }

        return $pairs;
    }

    /**
     * Получает победителей из указанного тура
     */
    private function getWinnersFromTour(int $tournamentId, int $tour): array
    {
        $games = $this->gameRepository->getByTournamentAndTour($tournamentId, $tour);
        $winners = [];

        foreach ($games as $game) {
            $winnerId = $this->determineGameWinner($game);
            if ($winnerId) {
                $winners[] = $winnerId;
            }
        }

        return $winners;
    }

    /**
     * Определяет победителя игры
     */
    private function determineGameWinner(Game $game): ?int
    {
        return $game->getWinners();
    }

    /**
     * Формирует пары команд для следующего тура
     */
    private function pairTeams(array $teamIds): array
    {
        shuffle($teamIds); // Перемешиваем для случайного распределения
        return array_chunk($teamIds, 2);
    }

    /**
     * Получает текущий тур турнира
     */
    private function getCurrentTour(int $tournamentId): int
    {
        $lastGame = Game::where('tournament_id', $tournamentId)
            ->orderBy('tour', 'desc')
            ->first();

        return $lastGame ? $lastGame->tour : 0;
    }
}
