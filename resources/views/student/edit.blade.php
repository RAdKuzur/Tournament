@extends('layouts.app')

@section('title', 'Редактирование участника')

@section('content')
    <div class="container mt-5">
        <h1>Редактировать участника</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('student.update', $student->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="surname" class="form-label">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname', $student->surname) }}" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="patronymic" class="form-label">Отчество</label>
                <input type="text" class="form-control" id="patronymic" name="patronymic" value="{{ old('patronymic', $student->patronymic) }}" required>
            </div>

            <div class="mb-3">
                <label for="olymp-score" class="form-label">Олимпиадный балл</label>
                <input type="text" class="form-control" id="olymp-score" name="olymp_score" value="{{ old('olymp_score', $student->olymp_score) }}" required>
            </div>

            <div class="mb-3">
                <label for="school" class="form-label">Выберите школу</label>
                <select id="school" name="school" class="form-select" required>
                    <option value="" disabled {{ !$student->school_id ? 'selected' : '' }}>— выберите школу —</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ $student->school_id == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                    <option value="moscow" {{ $student->school_id == 'moscow' ? 'selected' : '' }}>Москва</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
