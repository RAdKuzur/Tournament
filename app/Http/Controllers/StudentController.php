<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SchoolRepository;
use App\Http\Repositories\StudentRepository;
use App\Http\Services\AccessService;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    private StudentRepository $studentRepository;
    private SchoolRepository $schoolRepository;
    private AccessService $accessService;
    public function __construct(
        StudentRepository $studentRepository,
        SchoolRepository $schoolRepository,
        AccessService $accessService
    )
    {
        $this->studentRepository = $studentRepository;
        $this->schoolRepository = $schoolRepository;
        $this->accessService = $accessService;
    }

    public function index() {
        if($this->accessService->checkAccess()){
            $students = $this->studentRepository->getAll();
            return view('student.index', ['students' => $students]);
        }
        else {
            return redirect()->route('auth.logout');
        }

    }
    public function create() {
        if($this->accessService->checkAccess()){
            $schools = $this->schoolRepository->getAll();
            return view('student.create', ['schools' => $schools]);
        }
        else {
            return redirect()->route('student.index');
        }
    }
    public function store(Request $request) {
        if($this->accessService->checkAccess()){
            $data = $request->validate([
                'surname' => 'required|string|max:1000',
                'name' => 'required|string|max:1000',
                'patronymic' => 'string|max:1000',
                'olymp_score' => 'required|integer|max:1000',
                'school_id' => 'required|integer',
            ]);
            if (!$this->studentRepository->checkUnique($data['school_id'], $data['surname'], $data['name'], $data['patronymic'])) {
                $student = Student::create([
                    'surname' => $data['surname'],
                    'name' => $data['name'],
                    'patronymic' => $data['patronymic'],
                    'olymp_score' => $data['olymp_score'],
                    'school_id' => $data['school_id'],
                ]);
                return redirect()->route('student.show', ['id' => $student->id]);
            }
            return redirect('student/index');
        }
        else {
            return redirect()->route('student.index');
        }
    }
    public function show($id) {
        if($this->accessService->checkAccess()){
            $student = $this->studentRepository->get($id);
            return view('student.show', ['student' => $student]);
        }
        else {
            return redirect()->route('student.index');
        }
    }
    public function edit($id) {
        if($this->accessService->checkAccess()){
            $student = $this->studentRepository->get($id);
            $schools = $this->schoolRepository->getAll();
            return view('student.edit', [
                'schools' => $schools,
                'student' => $student
            ]);
        }
        else {
            return redirect()->route('student.index');
        }

    }
    public function update(Request $request, $id) {
        if($this->accessService->checkAccess()){
            $data = $request->validate([
                'surname' => 'required|string|max:1000',
                'name' => 'required|string|max:1000',
                'patronymic' => 'string|max:1000',
                'olymp_score' => 'required|integer|max:1000',
                'school_id' => 'required|integer',
            ]);
            if (!$this->studentRepository->checkUnique($data['school_id'], $data['surname'], $data['name'], $data['patronymic'])) {
                $student = $this->studentRepository->get($id);
                $student->update([
                    'surname' => $data['surname'],
                    'name' => $data['name'],
                    'patronymic' => $data['patronymic'],
                    'olymp_score' => $data['olymp_score'],
                    'school_id' => $data['school_id'],
                ]);
                return redirect()->route('student.show', ['id' => $student->id]);
            }
            return redirect('student/index');
        }
        else {
            return redirect()->route('student.index');
        }
    }
    public function destroy($id) {
        if($this->accessService->checkAccess()){
            $this->studentRepository->delete($id);
            return redirect('student/index');
        }
        else {
            return redirect()->route('student.index');
        }

    }
}
