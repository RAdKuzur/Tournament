<?php

namespace App\Http\Controllers;

use App\Http\Repositories\GameRepository;
use App\Http\Services\AccessService;
use App\Models\Game;

class GameController
{
//    private GameRepository
    private AccessService $accessService;
    public function edit($gameId) {
        if ($this->accessService->checkAccess()) {
            $game = Game::find(['id' => $gameId]);
        }
        return redirect()->route('index');

    }


}
