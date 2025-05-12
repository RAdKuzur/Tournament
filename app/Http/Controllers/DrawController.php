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
use App\Http\Services\DrawCircleService;
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
    private DrawCircleService $drawCircleService;
    public function __construct(
        GameRepository $gameRepository,
        AccessService $accessService,
        PlayOffService $playOffService,
        TournamentRepository $tournamentRepository,
        DrawSwissService $drawSwissService,
        DrawCircleService $drawCircleService
    )
    {
        $this->gameRepository = $gameRepository;
        $this->accessService = $accessService;
        $this->playOffService = $playOffService;
        $this->tournamentRepository = $tournamentRepository;
        $this->drawSwissService = $drawSwissService;
        $this->drawCircleService = $drawCircleService;
    }

    public function index($tournament_id)
    {
        if (!$this->accessService->checkAccess()) {
            return redirect()->route('auth.logout');
        }
        $tournament = $this->tournamentRepository->get($tournament_id);
        $games = $this->gameRepository->getByTournamentAndTour($tournament_id, $tournament->current_tour);

        return view('draw.index', [
            'games' => $games,
            'tournament' => $tournament,
        ]);
    }

    public function startTournament($tournament_id) {

        $tournament = $this->tournamentRepository->get($tournament_id);
        $games = $this->gameRepository->getAllGamesFromTournament($tournament_id);

        if (count($games) == 0) {
            switch ($tournament->type) {
                case TournamentTypeDictionary::SWISS:
                    $this->drawSwissService->createFirstGame($tournament_id);
                    break;
                case TournamentTypeDictionary::PLAY_OFF:
                    $pairs = $this->playOffService->generateInitialPlayOffRound($tournament_id);
                    $this->playOffService->createGamesFromPairs($pairs, $tournament_id);
                    break;
                case TournamentTypeDictionary::CIRCLE:
                    $this->drawCircleService->drawCircle($tournament_id);
                    break;
            }
        }

        return redirect()->route('draw.index', $tournament_id);
    }

    public function nextRound($id){
        $tournament = $this->tournamentRepository->get($id);
        switch ($tournament->type) {
            case TournamentTypeDictionary::SWISS:
                $this->drawSwissService->createNewGame($id);
                break;
            case TournamentTypeDictionary::PLAY_OFF:
                //функция жеребьёвки
                break;
            case TournamentTypeDictionary::CIRCLE:
                $this->drawCircleService->nextTour($id);
                break;
        }
        return redirect()->route('draw.index', $id);
    }

    public function Concluderound($tournament_id)
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
                        $this->drawSwissService->createNewGame($tournament_id);
                        break;
                    case TournamentTypeDictionary::PLAY_OFF:
                        $pairs = $this->playOffService->generateNextPlayOffRound($tournament_id);
                        $this->playOffService->createGamesFromPairs($pairs, $tournament_id);
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

    public function gamesTable($id)
    {
        if ($this->accessService->checkAccess()) {
            $tournament = $this->tournamentRepository->get($id);
            $games = $this->gameRepository->getByTournamentAndTour($id, $tournament->current_tour);
            return view('draw.games-table', [
                'games' => $games,
                'tournament' => $tournament,
            ]);
        }
        else {
            return redirect()->route('draw.index', [
                'id'
            ]);
        }
    }
}
