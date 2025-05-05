<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ActDefenceRepository;
use App\Http\Repositories\DefenceRepository;
use App\Http\Services\AccessService;
use App\Models\Defence;
use Illuminate\Http\Request;

class DefenceController extends Controller
{
    private AccessService $accessService;
    private DefenceRepository $defenceRepository;
    private ActDefenceRepository $actDefenceRepository;
    public function __construct(
        AccessService $accessService,
        DefenceRepository $defenceRepository,
        ActDefenceRepository $actDefenceRepository
    )
    {
        $this->accessService = $accessService;
        $this->defenceRepository = $defenceRepository;
        $this->actDefenceRepository = $actDefenceRepository;
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
    public function addParticipant(Request $request, $id)
    {
        $defence = $this->defenceRepository->get($id);
        $participants = $this->actDefenceRepository->getByDefenceId($id);
        if($request->all()){
            dd($request->all());
        }
        return view('defence.add-participant', [
                'defence' => $defence,
                'participants' => $participants
            ]
        );
    }
}
