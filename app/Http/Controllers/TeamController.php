<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SchoolRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TournamentRepository;
use App\Http\Services\TeamService;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    //
    private TeamRepository $teamRepository;
    private TournamentRepository $tournamentRepository;
    private StudentRepository $studentRepository;
    private SchoolRepository $schoolRepository;
    private TeamService $teamService;
    public function __construct(
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        StudentRepository $studentRepository,
        SchoolRepository $schoolRepository,
        TeamService $teamService
    )
    {
        $this->teamRepository = $teamRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->studentRepository = $studentRepository;
        $this->schoolRepository = $schoolRepository;
        $this->teamService = $teamService;
    }

    public function index() {
        $teams = $this->teamRepository->getAll();
        return view('team.index', [
            'teams' => $teams,
        ]);
    }
    public function create() {
        $tournaments = $this->tournamentRepository->getAll();
        $students = $this->studentRepository->getAll();
        $schools = $this->schoolRepository->getAll();
        return view('team.create', [
            'tournaments' => $tournaments,
            'students' => $students,
            'schools' => $schools,
        ]);
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:1000',
            'school_id' => 'required|integer',
            'tournament_id' => 'required|integer',
            'students' => 'required'
        ]);
        if(!$this->teamRepository->checkUnique($data['name'], $data['tournament_id'])) {
            $team = Team::create([
                    'name' => $data['name'],
                    'school_id' => $data['school_id'],
                    'tournament_id' => $data['tournament_id'],
                ]
            );
            $this->teamService->createTeamStudents($data['students'], $team);
            return redirect()->route('team.show', ['id' => $team->id]);
        }
        return redirect('team/index');
    }
    public function show($id) {
        $team = $this->teamRepository->get($id);
        return view('team.show', [
            'team' => $team
        ]);
    }
    public function edit($id) {
        $team = $this->teamRepository->get($id);
        $tournaments = $this->tournamentRepository->getAll();
        $students = $this->studentRepository->getAll();
        $schools = $this->schoolRepository->getAll();
        return view('team.edit', [
            'team' => $team,
            'tournaments' => $tournaments,
            'students' => $students,
            'schools' => $schools,
        ]);
    }
    public function update(Request $request, $id) {
        $team = $this->teamRepository->get($id);

        $data = $request->validate([
            'name' => 'required|string|max:1000',
            'school_id' => 'required|integer',
            'tournament_id' => 'required|integer',
            'students' => 'required'
        ]);
        if(!$this->teamRepository->checkUnique($data['name'], $data['tournament_id'])) {
            $team->update([
                'name' => $data['name'],
                'school_id' => $data['school_id'],
                'tournament_id' => $data['tournament_id'],
            ]);
        }
        $this->teamService->updateTeamStudents($data['students'], $team);
        return redirect()->route('team.show', ['id' => $team->id]);
    }
    public function destroy($id) {
        $this->teamRepository->delete($id);
        return redirect()->route('teams.index');
    }
}
