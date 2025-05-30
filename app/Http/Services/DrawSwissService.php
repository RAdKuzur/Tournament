<?php

namespace App\Http\Services;

use App\Http\Repositories\GameRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TeamStudentParticipantRepository;
use App\Http\Repositories\TeamStudentRepository;
use App\Http\Repositories\TournamentRepository;
use App\Models\Game;
use Ramsey\Collection\Collection;

class DrawSwissService
{
    private TournamentRepository $tournamentRepository;
    private GameRepository $gameRepository;
    private TeamRepository $teamRepository;
    private TeamStudentParticipantRepository $teamStudentParticipantRepository;

    public function __construct(
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        TeamStudentRepository $teamStudentRepository,
        GameRepository $gameRepository,
        TeamStudentParticipantRepository $teamStudentParticipantRepository
    ) {
        $this->tournamentRepository = $tournamentRepository;
        $this->gameRepository = $gameRepository;
        $this->teamRepository = $teamRepository;
        $this->teamStudentParticipantRepository = $teamStudentParticipantRepository;
    }


    public function createFirstGame($tournamentId)
    {
        $tournament = $this->tournamentRepository->get($tournamentId);
        $teams = $this->teamRepository->getAllbytournament($tournamentId);

        // Собираем стартовые олимпийские баллы
        $teamScores = $teams->mapWithKeys(function($team) {
            return [$team->id => $team->getOlympScore()];
        })->sortDesc();

        // Сортируем команды по убыванию баллов
        $sortedTeams = $teamScores->keys()->toArray();

        // Формируем пары: сильнейший vs следующий сильнейший
        $this->createPairs($sortedTeams, $tournamentId, 1);

        $this->tournamentRepository->nextTour($tournamentId);

    }

    public function createNewGame($tournamentId)
    {
        $tournament = $this->tournamentRepository->get($tournamentId);
        $newTour = $tournament->current_tour + 1;
        $teams = $this->teamRepository->getAllbytournament($tournamentId);

        $teamCount = count($teams);
        if (!$this->checkMaxTour($teamCount, $newTour)) {
            return "Количество туров достигло максимума";
        }

        if (!$this->checkWinInAllGames($tournamentId, $tournament->current_tour)) {
            return "Не все игры могут быть завершены";
        }

        // Получаем статистику команд
        $teamStats = $this->getTeamStats($teams);

        // Сортируем команды по критериям
        $sortedTeams = $this->sortTeams($teamStats);

        // Формируем пары для нового тура
        $this->createPairs($sortedTeams, $tournamentId, $newTour);

        // Обновляем номер текущего тура
        $this->tournamentRepository->nextTour($tournamentId);
    }

    //Проверяем не превышаем ли мы максимальное кол-во туров
    private function checkMaxTour(int $teamCount, int $newTour): bool {
        $adjustedCount = $teamCount % 2 === 0 ? $teamCount : $teamCount + 1;
        if ($newTour > (int) ceil(log($adjustedCount, 2))) {
            return false;
        }
        return true;
    }

    //Проверяем есть ли победитель в каждой игре
    private function  checkWinInAllGames(int $tournament_id, int $tour): bool {
        $games = $this->gameRepository->getByTournamentAndTour($tournament_id, $tour);
        foreach ($games as $game) {
            if ($game->getFirstTeamScore() == $game->getSecondTeamScore()) {
                return false;
            }
        }
        return true;
    }

    private function getTeamStats($teams): \Illuminate\Support\Collection
    {
        $stats = collect();
        foreach ($teams as $team) {
            $games = Game::where('first_team_id', $team->id)
                ->orWhere('second_team_id', $team->id)
                ->get();

            $wins = 0;
            $totalScore = 0;
            $playedAgainst = [];

            foreach ($games as $game) {
                // Определяем результат игры
                $isFirstTeam = $game->first_team_id == $team->id;
                $teamScore = $isFirstTeam ? $game->getFirstTeamScore() : $game->getSecondTeamScore();
                $opponentScore = $isFirstTeam ? $game->getSecondTeamScore() : $game->getFirstTeamScore();

                $totalScore += $teamScore;

                if ($teamScore > $opponentScore) {
                    $wins++;
                }

                $opponentId = $isFirstTeam ? $game->second_team_id : $game->first_team_id;
                $playedAgainst[] = $opponentId;
            }

            $stats->push([
                'team_id' => $team->id,
                'wins' => $wins,
                'total_score' => $totalScore,
                'start_score' => $team->getOlympScore(),
                'played_against' => $playedAgainst
            ]);
        }

        return $stats;
    }

    private function sortTeams($stats): array
    {
        return $stats->sortByDesc(function($team) {
            return [
                $team['wins'],         // Основной критерий - победы
                $team['total_score'],  // Вторичный - набранные очки
                $team['start_score']  // Третичный - стартовые очки
            ];
        })->pluck('team_id')->toArray();
    }

    private function createPairs(array $teamIds, int $tournamentId, int $tourNumber)
    {
        $pairs = [];
        $used = [];
        $totalTeams = count($teamIds);

        for ($i = 0; $i < $totalTeams; $i++) {
            if (in_array($teamIds[$i], $used)) continue;

            // Поиск соперника
            for ($j = $i + 1; $j < $totalTeams; $j++) {
                if (!in_array($teamIds[$j], $used) &&
                    !$this->havePlayedBefore($teamIds[$i], $teamIds[$j])) {

                    $pairs[] = [$teamIds[$i], $teamIds[$j]];
                    $used[] = $teamIds[$i];
                    $used[] = $teamIds[$j];
                    break;
                }
            }

            // Если не нашли соперника - bye
            if (!in_array($teamIds[$i], $used)) {
                $pairs[] = [$teamIds[$i], null];
                $used[] = $teamIds[$i];
            }
        }

        // Создаем игры
        foreach ($pairs as $pair) {
            if ($pair[1] !== null) {
                $game = $this->gameRepository->create(
                    $pair[0],
                    $pair[1],
                    $tournamentId,
                    $tourNumber
                );

                $firstTeam = $this->teamRepository->get($pair[0]);
                $secondTeam = $this->teamRepository->get($pair[1]);

                $this->teamStudentParticipantRepository->createParticipants($firstTeam->teamStudents, $game->id);
                $this->teamStudentParticipantRepository->createParticipants($secondTeam->teamStudents, $game->id);
            }
        }
    }

    private function havePlayedBefore(int $team1, int $team2): bool
    {
        return Game::where(function($q) use ($team1, $team2) {
            $q->where('first_team_id', $team1)
                ->where('second_team_id', $team2);
        })->orWhere(function($q) use ($team1, $team2) {
            $q->where('first_team_id', $team2)
                ->where('second_team_id', $team1);
        })->exists();
    }
}
