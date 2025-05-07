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
    private TournamentRepository $tournamentRepository;
    private GameRepository $gameRepository;
    private TeamRepository $teamRepository;

    public function __construct(
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        TeamStudentRepository $teamStudentRepository,
        GameRepository $gameRepository
    ) {
        $this->tournamentRepository = $tournamentRepository;
        $this->gameRepository = $gameRepository;
        $this->teamRepository = $teamRepository;
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
    }

    public function createNewGame($tournamentId)
    {
        $tournament = $this->tournamentRepository->get($tournamentId);
        $currentTour = $tournament->current_tour + 1;

        // Получаем статистику команд
        $teamStats = $this->getTeamStats($tournament);

        // Сортируем команды по критериям
        $sortedTeams = $this->sortTeams($teamStats);

        // Формируем пары для нового тура
        $this->createPairs($sortedTeams, $tournamentId, $currentTour);

        // Обновляем номер текущего тура
        $tournament->update(['current_tour' => $currentTour]);
    }

    private function getTeamStats($tournament)
    {
        $stats = collect();

        foreach ($tournament->teams as $team) {
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
                $this->gameRepository->create(
                    $pair[0],
                    $pair[1],
                    $tournamentId,
                    $tourNumber
                );
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
//    public function createFirstGame($tournamentId) {
//        $tournament = $this->tournamentRepository->get($tournamentId);
//        $teams = $tournament->team;
//        $teamScore = [];
//        foreach ($teams as $team) {
//            $teamScore[$team->id] = $team->getOlympScore();
//        }
//        asort($teamScore);
//        $sortedTeamIds = array_keys($teamScore);
//
//        for ($i = 0; $i < count($teamScore); $i+=2) {
//            $firstTeamId =  $sortedTeamIds[$i];
//            $secondTeamId =  $sortedTeamIds[$i+1];
//
//            $this->gameRepository->create($firstTeamId, $secondTeamId, $tournamentId, 1);
//        }
//    }
//
//    public function createNewGame($tournamentId) {
//        $tournament = $this->tournamentRepository->get($tournamentId);
//        $teams = $tournament->team;
//        //номер текущего тура
//        $currentTour = $tournament->current_tour;
//
//        //Определить кол-во побед для каждой команды
//        $countWinTeams = [];
//        $games = $tournament->games;
//        foreach ($games as $game) {
//            $firstTeamId = $game->firstTeam;
//            $secondTeamId = $game->secondTeam;
//
//            $firstTeamStudentIds = $firstTeamId->teamStudents->pluck('id');
//            $secondTeamStudentIds = $secondTeamId->teamStudents->pluck('id');
//
//            $firstTeamScore = $game->participants
//                ->whereIn('team_student_id', $firstTeamStudentIds)
//                ->sum('score');
//
//            $secondTeamScore = $game->participants
//                ->whereIn('team_student_id', $secondTeamStudentIds)
//                ->sum('score');
//
//            // Определяем победителя
//            if ($firstTeamScore > $secondTeamScore) {
//                $countWinTeams[$firstTeamId] += 1;
//            } else {
//                $countWinTeams[$secondTeamId] += 1;
//            }
//        }
//
//        //Определить кол-во очков для каждой команды
//        $scoreTeams = [];
//        foreach ($teams as $team) {
//            $games = Game::where('first_team_id', $team->id)->orWhere('second_team_id')->get();
//            $scoreTeam = 0;
//            foreach ($games as $game) {
//
//                $teamStudentsIds = $team->teamStudent->pluck('id');
//                $score = $game->participants
//                    ->whereIn('team_student_id', $teamStudentsIds)
//                    ->sum('score');
//                $scoreTeam+=$score;
//
////                $teamStudents = $team->teamStudent;
////                foreach ($teamStudents as $student) {
////                    $score = TeamStudentRepository::where('team_student_id', $student->id)
////                        ->andWhere('game_id', $game->id)->score;
////                    $scoreTeam += $score;
////                }
//            }
//            $scoreTeams[$team->id] = $scoreTeam;
//        }
//
//        //Определить
//        asort();
//
//

//    }
}
