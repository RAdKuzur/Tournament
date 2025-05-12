@extends('layouts.app')

@section('title', 'Редактирование участника')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Редактирование участника</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Редактирование участника</h1>
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
            <input type="text" class="form-control" id="surname" name="surname"
                   value="{{ old('surname', $student->surname) }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name', $student->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="patronymic" class="form-label">Отчество</label>
            <input type="text" class="form-control" id="patronymic" name="patronymic"
                   value="{{ old('patronymic', $student->patronymic) }}">
        </div>
        <div class="mb-3">
            <label for="olymp-score" class="form-label">Олимпиадный балл</label>
            <input type="text" class="form-control" id="olymp-score" name="olymp_score"
                   value="{{ old('olymp_score', $student->olymp_score) }}" required>
        </div>
        <div class="mb-3">
            <label for="school" class="form-label">Школа</label>
            <input type="text" class="form-control" value="{{$student->school->name}}" readonly/>

        </div>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('student.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
</body>
</html>
@endsection
