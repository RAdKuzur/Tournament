<?php

namespace App\Http\Controllers;

use App\Http\Repositories\GameRepository;
use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TeamStudentParticipantRepository;
use App\Http\Services\AccessService;
use App\Models\Game;
use App\Models\TeamStudentParticipant;

class GameController extends Controller
{
//    private GameRepository

    private AccessService $accessService;
    private GameRepository $gameRepository;
    private TeamStudentParticipantRepository $teamStudentParticipantRepository;

    public function __construct(
        AccessService $accessService,
        GameRepository $gameRepository,
        TeamStudentParticipantRepository $teamStudentParticipantRepository
    ){
        $this->accessService = $accessService;
        $this->gameRepository = $gameRepository;
        $this->teamStudentParticipantRepository = $teamStudentParticipantRepository;
    }
    public function index($id){
        $game = $this->gameRepository->get($id);
        if ($this->accessService->checkAccess()) {
            return view('game.index',[
                'game' => $game
            ]);
        }
        return redirect()->route('draw.index', [
            'id' => $game->touranment->id
        ]);

    }
    public function changeScore($id, $type, $score, $gameId){
        $this->teamStudentParticipantRepository->changeScore($id, $type, $score, $gameId);
        return redirect()->route('game.index', $gameId);
    }
}
