<?php

namespace App\Http\Controllers;

use App\Components\DefenceTypeDictionary;
use App\Components\TournamentTypeDictionary;
use App\Http\Repositories\ActDefenceRepository;
use App\Http\Repositories\DefenceParticipantRepository;
use App\Http\Repositories\DefenceRepository;
use App\Http\Repositories\GameRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\TournamentRepository;
use App\Http\Services\AccessService;
use App\Http\Services\DrawSwissService;
use App\Http\Services\PlayOffService;
use App\Models\Defence;
use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Http\Request;


class DrawController extends Controller
{
    //
    private GameRepository $gameRepository;
    private TournamentRepository $tournamentRepository;

    private AccessService $accessService;

    private PlayOffService $playOffService;
    private DrawSwissService $drawSwissService;
    public function __construct(
        GameRepository $gameRepository,
        AccessService $accessService,
        PlayOffService $playOffService,
        TournamentRepository $tournamentRepository,
        DrawSwissService $drawSwissService

    )
    {
        $this->gameRepository = $gameRepository;
        $this->accessService = $accessService;
        $this->playOffService = $playOffService;
        $this->tournamentRepository = $tournamentRepository;
        $this->drawSwissService = $drawSwissService;
    }

    public function index($tournament_id)
    {
        if (!$this->accessService->checkAccess()) {
            return redirect()->route('auth.logout');
        }

        $games = $this->gameRepository->getAllGamesFromTournament($tournament_id);

        if (count($games) == 0) {
            try {
                $tournament = $this->tournamentRepository->get($tournament_id);
                switch ($tournament->type) {
                    case TournamentTypeDictionary::SWISS:
                        $this->drawSwissService->createFirstGame($tournament_id);
                        break;
                    case TournamentTypeDictionary::PLAY_OFF:
                        $pairs = $this->playOffService->generateInitialPlayOffRound($tournament_id);
                        $this->createGamesFromPairs($pairs, $tournament_id);
                        break;
                }
                // Обновляем список игр после создания
                $games = $this->gameRepository->getAllGamesFromTournament($tournament_id);

            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', $e->getMessage());
            }
        }

        return view('Draw.index', ['games' => $games]);
    }

    private function createGamesFromPairs(array $pairs, int $tournamentId): void
    {
        foreach ($pairs as $pair) {
            Game::create([
                'first_team_id' => $pair[0],
                'second_team_id' => $pair[1],
                'tournament_id' => $tournamentId,
                'tour' => Tournament::INIT_TOUR,
            ]);
        }
    }



}
