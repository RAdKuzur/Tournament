<?php

namespace App\Http\Controllers;

use App\Components\DefenceTypeDictionary;
use App\Http\Repositories\ActDefenceRepository;
use App\Http\Repositories\DefenceParticipantRepository;
use App\Http\Repositories\DefenceRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Services\AccessService;
use App\Http\Services\DefenceService;
use App\Models\Defence;
use Illuminate\Http\Request;

class DefenceController extends Controller
{
    private AccessService $accessService;
    private DefenceRepository $defenceRepository;
    private DefenceService $defenceService;
    private ActDefenceRepository $actDefenceRepository;
    private DefenceParticipantRepository $defenceParticipantRepository;
    private StudentRepository $studentRepository;
    public function __construct(
        AccessService $accessService,
        DefenceRepository $defenceRepository,
        DefenceService $defenceService,
        ActDefenceRepository $actDefenceRepository,
        DefenceParticipantRepository $defenceParticipantRepository,
        StudentRepository $studentRepository
    )
    {
        $this->accessService = $accessService;
        $this->defenceRepository = $defenceRepository;
        $this->defenceService = $defenceService;
        $this->actDefenceRepository = $actDefenceRepository;
        $this->defenceParticipantRepository = $defenceParticipantRepository;
        $this->studentRepository = $studentRepository;
    }
    public function index() {
        if ($this->accessService->checkAccess()){
            $defences = $this->defenceRepository->getAll();
            return view('defence.index', ['defences' => $defences]);
        }
        else {
            return redirect()->route('auth.logout');
        }
    }
    public function create() {
        if ($this->accessService->checkAccess()){
            $types = $this->defenceRepository->getTypes();
            return view('defence.create', ['types' => $types]);
        }
        else {
            return redirect()->route('defence.index');
        }
    }
    public function store(Request $request) {
        if ($this->accessService->checkAccess()){
            $data = $request->validate([
                'name' => 'required|string|max:1000',
                'type' => 'required|integer',
                'date' => 'required|date',
            ]);
            if(!$this->defenceRepository->checkUnique($data['name'], $data['date'], $data['type'])) {
                $defence = Defence::create([
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'date' => $data['date']
                ]);
                return redirect()->route('defence.show', ['id' => $defence->id]);
            }
            return redirect()->route('defence.create');
        }
        else {
            return redirect()->route('defence.index');
        }
    }
    public function show($id) {
        if ($this->accessService->checkAccess()){
            $defence = $this->defenceRepository->get($id);
            return view('defence.show', ['defence' => $defence]);
        }
        else {
            return redirect()->route('defence.index');
        }
    }
    public function edit($id) {
        if ($this->accessService->checkAccess()){
            $defence = $this->defenceRepository->get($id);
            $types = $this->defenceRepository->getTypes();
            return view('defence.edit', [
                'defence' => $defence,
                'types' => $types
            ]);
        }
        else {
            return redirect()->route('defence.index');
        }
    }
    public function update(Request $request, $id) {
        if ($this->accessService->checkAccess()){
            $data = $request->validate([
                'name' => 'required|string|max:1000',
                'type' => 'required|integer',
                'date' => 'required|date',
            ]);
            if(!$this->defenceRepository->checkUnique($data['name'], $data['date'], $data['type'])) {
                $defence = $this->defenceRepository->get($id);
                $defence->update([
                     'name' => $data['name'],
                     'type' => $data['type'],
                     'date' => $data['date']
                ]);
                return redirect()->route('defence.show', ['id' => $defence->id]);
            }
            return redirect()->route('defence.edit', ['id' => $id]);
        }
        else {
            return redirect()->route('defence.index');
        }
    }
    public function destroy($id)
    {
        if ($this->accessService->checkAccess()){
            $this->defenceRepository->delete($id);
            return redirect()->route('defence.index');
        }
        else {
            return redirect()->route('defence.index');
        }
    }
    public function actDefence(Request $request, $id)
    {
        if ($this->accessService->checkAccess()){
            $defence = $this->defenceRepository->get($id);
            if($defence->type == DefenceTypeDictionary::PERSONAL) {
                $students = $this->studentRepository->getAll();
                $participants = $this->defenceParticipantRepository->getByActDefences($defence->actDefences);
                if($request->isMethod('POST')) {
                    $data = $request->validate([
                        'participants' => 'array|max:1000',
                    ]);
                    $this->defenceService->addPersonalDefence($data['participants'], $defence->id);
                    /*$actDefence = $this->actDefenceRepository->create('Личная защита.', $defence->id);
                    $this->defenceService->addTeamParticipants($actDefence->id, $data['participants']);*/
                    return redirect()->route('defence.act-defence', ['id' => $defence->id]);
                }
                return view('defence.add-personal-participant', [
                        'defence' => $defence,
                        'students' => $students,
                        'participants' => $participants
                    ]
                );
            }
            else {
                $actDefences = $this->actDefenceRepository->getByDefenceId($id);
                if($request->isMethod('POST')) {
                    $data = $request->validate([
                        'team' => 'array|max:1000',
                    ]);
                    $this->defenceService->addTeams($data['team'], $defence->id);
                    return redirect()->route('defence.act-defence', ['id' => $defence->id]);
                }
                return view('defence.add-team-participant', [
                        'defence' => $defence,
                        'actDefences' => $actDefences
                    ]
                );
            }
        }
        else {
            return redirect()->route('defence.index');
        }
    }
    public function addTeamParticipant(Request $request, $id)
    {
        $team = $this->actDefenceRepository->get($id);
        $participants = $this->defenceParticipantRepository->getParticipants($id);
        $students = $this->studentRepository->getAll();
        if ($this->accessService->checkAccess()) {
            if ($request->isMethod('POST')) {
                $data = $request->validate([
                    'participants' => 'array|max:1000',
                ]);
                $this->defenceService->addTeamParticipants($team->id, $data['participants']);
                return redirect()->route('defence.add-team-participant', ['id' => $team->id]);
            }
        }
        return view('defence.team-participant', [
            'team' => $team,
            'participants' => $participants,
            'students' => $students
        ]);
    }
    public function deleteActParticipant($id)
    {
        $defenceId = ($this->actDefenceRepository->get($id))->defence_id;
        $this->actDefenceRepository->delete($id);
        return redirect()->route('defence.act-defence', ['id' => $defenceId]);
    }
    public function deleteDefenceParticipant($id)
    {
        $team = $this->defenceParticipantRepository->get($id);
        $this->defenceParticipantRepository->delete($id);
        if ($team->actDefence->defence->type == DefenceTypeDictionary::PERSONAL) {
            $this->actDefenceRepository->delete($team->actDefence->id);
        }
        return redirect()->route('defence.act-defence', ['id' => $team->actDefence->defence->id]);
    }
}
