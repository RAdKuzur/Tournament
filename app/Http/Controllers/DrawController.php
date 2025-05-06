<?php

namespace App\Http\Controllers;

use App\Components\DefenceTypeDictionary;
use App\Http\Repositories\ActDefenceRepository;
use App\Http\Repositories\DefenceParticipantRepository;
use App\Http\Repositories\DefenceRepository;
use App\Http\Repositories\GameRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\TournamentRepository;
use App\Http\Services\AccessService;
use App\Models\Defence;
use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Http\Request;


class DrawController extends Controller
{
    //
    private GameRepository $gameRepository;
    private AccessService $accessService;
    public function __construct(
        GameRepository $gameRepository,
        AccessService $accessService
    )
    {
        $this->gameRepository = $gameRepository;
        $this->accessService = $accessService;
    }

    public function index($tournament_id) {
        $games = $this->gameRepository->getAllGamesFromTournament($tournament_id);
        if (count($games)>0)
        {
            return view('Draw.index', ['games' => $games]);
        }

        return view('Draw.index', ['games' => $games]);

        /*if($this->accessService->checkAccess()) {

        }
        else {
            return redirect()->route('auth.logout');
        }*/
    }
}
