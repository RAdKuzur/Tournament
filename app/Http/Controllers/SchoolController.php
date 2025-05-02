<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SchoolRepository;
use App\Http\Services\AccessService;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    //
    private SchoolRepository $schoolRepository;
    private AccessService $accessService;
    public function __construct(
        SchoolRepository $schoolRepository,
        AccessService $accessService
    )
    {
        $this->schoolRepository = $schoolRepository;
        $this->accessService = $accessService;
    }
    public function index() {
        if ($this->accessService->checkAccess()){
            $schools = $this->schoolRepository->getAll();
            return view('school.index', ['schools' => $schools]);
        }
        else {
            return redirect()->route('auth.logout');
        }
    }
    public function create() {
        if ($this->accessService->checkAccess()){
            return view('school.create');
        }
        else {
            return redirect()->route('school.index');
        }
    }
    public function store(Request $request) {
        if ($this->accessService->checkAccess()){
            $data = $request->validate([
                'name' => 'required | string | max:1000'
            ]);
            if (!$this->schoolRepository->checkUnique($data['name'])) {
                $school = School::create(['name' => $data['name']]);
                return redirect()->route('school.show', ['id' => $school->id]);
            }
            return redirect('school/index');
        }
        else {
            return redirect()->route('school.index');
        }
    }
    public function show($id) {
        if ($this->accessService->checkAccess()){
            $school = $this->schoolRepository->get($id);
            return view('school.show',  ['school' => $school]);
        }
        else {
            return redirect()->route('school.index');
        }
    }
    public function edit($id) {
        if ($this->accessService->checkAccess()) {
            $school = $this->schoolRepository->get($id);
            return view('school.edit', ['school' => $school]);
        }
        else {
            return redirect()->route('school.index');
        }
    }
    public function update(Request $request, $id) {
        if ($this->accessService->checkAccess()) {
            $data = $request->validate([
                'name' => 'required | string | max:1000'
            ]);
            if (!$this->schoolRepository->checkUnique($data['name'])) {
                $school = $this->schoolRepository->get($id);
                $school->update(['name' => $data['name']]);
                return redirect()->route('school.show', ['id' => $school->id]);
            }
            return redirect('school/index');
        }
        else {
            return redirect()->route('school.index');
        }
    }
    public function destroy($id) {
        if ($this->accessService->checkAccess()){
            $this->schoolRepository->delete($id);
            return redirect('school/index');
        }
        else {
            return redirect()->route('school.index');
        }
    }
}
