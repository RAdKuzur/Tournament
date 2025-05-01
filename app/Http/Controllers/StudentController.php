<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SchoolRepository;
use App\Http\Repositories\StudentRepository;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    private StudentRepository $studentRepository;
    private SchoolRepository $schoolRepository;
    public function __construct(
        StudentRepository $studentRepository,
        SchoolRepository $schoolRepository
    )
    {
        $this->studentRepository = $studentRepository;
        $this->schoolRepository = $schoolRepository;
    }

    public function index() {
        $students = $this->studentRepository->getAll();
        return view('student.index', ['students' => $students]);
    }
    public function create() {
        $schools = $this->schoolRepository->getAll();
        return view('student.create', ['schools' => $schools]);
    }
    public function store(Request $request) {
        $data = $request->validate([
            'surname' => 'required|string|max:1000',
            'name' => 'required|string|max:1000',
            'patronymic' => 'string|max:1000',
            'olymp_score' => 'required|integer|max:1000',
            'school_id' => 'required|integer',
        ]);
        if(!$this->studentRepository->checkUnique($data['school_id'], $data['surname'], $data['name'], $data['patronymic'])) {
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
    public function show($id) {
        $student = $this->studentRepository->get($id);
        return view('student.show', ['student' => $student]);
    }
    public function edit($id) {
        $student = $this->studentRepository->get($id);
        $schools = $this->schoolRepository->getAll();
        return view('student.edit', [
            'schools' => $schools,
            'student' => $student
        ]);
    }
    public function update(Request $request, $id) {
        $data = $request->validate([
            'surname' => 'required|string|max:1000',
            'name' => 'required|string|max:1000',
            'patronymic' => 'string|max:1000',
            'olymp_score' => 'required|integer|max:1000',
            'school_id' => 'required|integer',
        ]);
        if(!$this->studentRepository->checkUnique($data['school_id'], $data['surname'], $data['name'], $data['patronymic'])) {
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
    public function destroy($id) {
        $this->studentRepository->delete($id);
        return redirect('student/index');
    }
}
