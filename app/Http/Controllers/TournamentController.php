<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TournamentRepository;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    //
    private TournamentRepository $tournamentRepository;
    public function __construct(
        TournamentRepository $tournamentRepository
    )
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    public function index() {
        $tournaments = Tournament::all();
        return view('tournament.index', compact('tournaments'));
    }
    public function create() {
        $types = $this->tournamentRepository->getTypes();
        return view('tournament.create', compact('types'));
    }
    public function store(Request $request) {
       $data = $request->validate([
           'name' => 'required | string | max:1000',
           'begin_date' => 'required | date',
           'finish_date' => 'required | date',
           'type' => 'required',
       ]);
       if(!$this->tournamentRepository->checkUnique($data['name'], $data['begin_date'], $data['finish_date'])) {
           $tournament = Tournament::create([
               'name' => $data['name'],
               'begin_date' => $data['begin_date'],
               'finish_date' => $data['finish_date'],
               'type' => $data['type']
           ]);
           return redirect()->route('tournament.show', ['id' => $tournament->id]);
       }
        return redirect('tournament/index');
    }
    public function show($id) {
        $tournament = $this->tournamentRepository->get($id);
        return view('tournament.show', compact('tournament'));
    }
    public function edit($id) {
        $tournament = $this->tournamentRepository->get($id);
        $types = $this->tournamentRepository->getTypes();
        return view('tournament.edit', compact('tournament', 'types'));
    }
    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required | string | max:1000',
            'begin_date' => 'required | date',
            'finish_date' => 'required | date',
            'type' => 'required',
        ]);
        if(!$this->tournamentRepository->checkUnique($data['name'], $data['begin_date'], $data['finish_date'])) {
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
    public function destroy($id) {
        $this->tournamentRepository->delete($id);
        return redirect()->route('tournament.index');
    }
}
