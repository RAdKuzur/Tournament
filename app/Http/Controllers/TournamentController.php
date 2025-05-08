<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TournamentRepository;
use App\Http\Services\AccessService;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    //
    private TournamentRepository $tournamentRepository;
    private AccessService $accessService;
    private TeamRepository $teamRepository;
    public function __construct(
        TournamentRepository $tournamentRepository,
        AccessService $accessService,
        TeamRepository $teamRepository
    )
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->accessService = $accessService;
        $this->teamRepository = $teamRepository;
    }

    public function index() {
        if($this->accessService->checkAccess()) {
            $tournaments = Tournament::all();
            return view('tournament.index', compact('tournaments'));
        }
        else {
            return redirect()->route('auth.logout');
        }
    }
    public function create() {
        if($this->accessService->checkAccess()) {
            $types = $this->tournamentRepository->getTypes();
            return view('tournament.create', compact('types'));
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function store(Request $request) {
        if($this->accessService->checkAccess()){
            $data = $request->validate([
                'name' => 'required | string | max:1000',
                'begin_date' => 'required | date',
                'finish_date' => 'required | date',
                'type' => 'required',
            ]);
            if (!$this->tournamentRepository->checkUnique($data['name'], $data['begin_date'], $data['finish_date'])) {
                $tournament = Tournament::create([
                    'name' => $data['name'],
                    'begin_date' => $data['begin_date'],
                    'finish_date' => $data['finish_date'],
                    'type' => $data['type'],
                    'current_tour' => Tournament::INIT_TOUR
                ]);
                return redirect()->route('tournament.show', ['id' => $tournament->id]);
            }
            return redirect('tournament/index');
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function show($id) {
        if($this->accessService->checkAccess()){
            $tournament = $this->tournamentRepository->get($id);
            return view('tournament.show', compact('tournament'));
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function edit($id) {
        if($this->accessService->checkAccess()){
            $tournament = $this->tournamentRepository->get($id);
            $types = $this->tournamentRepository->getTypes();
            return view('tournament.edit', compact('tournament', 'types'));
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function update(Request $request, $id) {
        if($this->accessService->checkAccess()){
            $data = $request->validate([
                'name' => 'required | string | max:1000',
                'begin_date' => 'required | date',
                'finish_date' => 'required | date',
                'type' => 'required',
            ]);
            if (!$this->tournamentRepository->checkUnique($data['name'], $data['begin_date'], $data['finish_date'])) {
                $tournament = $this->tournamentRepository->get($id);
                $tournament->update([
                    'name' => $data['name'],
                    'begin_date' => $data['begin_date'],
                    'finish_date' => $data['finish_date'],
                    'type' => $data['type']
                ]);
                return redirect()->route('tournament.show', ['id' => $tournament->id]);
            }
            return redirect('tournament/index');
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function teamLeaderboard($id) {
        if($this->accessService->checkAccess()){
            $teams = $this->teamRepository->getAllbytournament($id);
            return view('tournament.team-leaderboard',
                [
                    'teams' => $teams,
                ]
            );
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function personalLeaderboard($id) {
        if($this->accessService->checkAccess()){
            $teams = $this->teamRepository->getAllbytournament($id);
            return view('tournament.personal-leaderboard',
                [
                    'teams' => $teams,
                ]
            );
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
    public function destroy($id) {
        if($this->accessService->checkAccess()){
            $this->tournamentRepository->delete($id);
            return redirect()->route('tournament.index');
        }
        else {
            return redirect()->route('tournament.index');
        }
    }
}
