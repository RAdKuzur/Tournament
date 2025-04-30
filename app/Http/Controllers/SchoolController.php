<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SchoolRepository;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    //
    private SchoolRepository $schoolRepository;
    public function __construct(
        SchoolRepository $schoolRepository
    )
    {
        $this->schoolRepository = $schoolRepository;
    }
    public function index() {
        $schools = $this->schoolRepository->getAll();
        return view('school.index', ['schools' => $schools]);
    }
    public function create() {
        return view('school.create');
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required | string | max:1000'
        ]);
        if (!$this->schoolRepository->checkUnique($data['name'])) {
            $school = School::create(['name' => $data['name']]);
            return redirect()->route('school.show', ['id' => $school->id]);
        }
        return redirect('school/index');
    }
    public function show($id) {
        $school = $this->schoolRepository->get($id);
        return view('school.show',  ['school' => $school]);
    }
    public function edit($id) {
        $school = $this->schoolRepository->get($id);
        return view('school.edit', ['school' => $school]);
    }
    public function update(Request $request, $id) {
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
    public function destroy($id) {
        $this->schoolRepository->delete($id);
        return redirect('school/index');
    }
}
