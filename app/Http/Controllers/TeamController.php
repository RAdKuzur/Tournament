<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SchoolRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Repositories\TeamRepository;
use App\Http\Repositories\TournamentRepository;
use App\Http\Services\AccessService;
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
    private AccessService $accessService;
    public function __construct(
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        StudentRepository $studentRepository,
        SchoolRepository $schoolRepository,
        TeamService $teamService,
        AccessService $accessService
    )
    {
        $this->teamRepository = $teamRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->studentRepository = $studentRepository;
        $this->schoolRepository = $schoolRepository;
        $this->teamService = $teamService;
        $this->accessService = $accessService;
    }

    public function index() {
        if($this->accessService->checkAccess()){
            $teams = $this->teamRepository->getAll();
            return view('team.index', [
                'teams' => $teams,
            ]);
        }
        else {
            return redirect()->route('auth.logout');
        }
    }
    public function create() {
        if($this->accessService->checkAccess()){
            $tournaments = $this->tournamentRepository->getAll();
            $students = $this->studentRepository->getAll();
            $schools = $this->schoolRepository->getAll();
            return view('team.create', [
                'tournaments' => $tournaments,
                'students' => $students,
                'schools' => $schools,
            ]);
        }
        else {
            return redirect()->route('team.index');
        }
    }
    public function store(Request $request) {
        if($this->accessService->checkAccess()) {
            $data = $request->validate([
                'name' => 'required|string|max:1000',
                'school_id' => 'required|integer',
                'tournament_id' => 'required|integer',
                'students' => 'required'
            ]);
            if (!$this->teamRepository->checkUnique($data['name'], $data['tournament_id'])) {
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
        else {
            return redirect()->route('team.index');
        }
    }
    public function show($id) {
        if($this->accessService->checkAccess()) {
            $team = $this->teamRepository->get($id);
            return view('team.show', [
                'team' => $team
            ]);
        }
        else {
            return redirect()->route('team.index');
        }
    }
    public function edit($id) {
        if($this->accessService->checkAccess()) {
            $team = $this->teamRepository->get($id);
            $students = $this->studentRepository->getBySchoolId($team->school->id);
            return view('team.edit', [
                'team' => $team,
                'students' => $students,
            ]);
        }
        else {
            return redirect()->route('team.index');
        }
    }

    public function getBySchool($id) {
        if($this->accessService->checkAccess()) {
            $students = $this->studentRepository->getBySchoolId($id);
            return response()->json($students);
        } else {
            return redirect()->route('team.index');
        }
    }


    public function update(Request $request, $id) {
        if($this->accessService->checkAccess()) {
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
        else {
            return redirect()->route('team.index');
        }
    }
    public function destroy($id) {
        if($this->accessService->checkAccess()) {
            $this->teamRepository->delete($id);
            return redirect()->route('teams.index');
        }
        else {
            return redirect()->route('team.index');
        }
    }
}
