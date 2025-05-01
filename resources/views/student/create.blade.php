@extends('layouts.app')

@section('title', 'Создание участника')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Форма участника</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Создание участника</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('student.store') }}">
        @csrf
        <div class="mb-3">
            <label for="surname" class="form-label">Фамилия </label>
            <input type="text" class="form-control" id="surname" name="surname" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="patronymic" class="form-label">Отчество</label>
            <input type="text" class="form-control" id="patronymic" name="patronymic">
        </div>
        <div class="mb-3">
            <label for="olymp-score" class="form-label">Олимпиадный балл</label>
            <input type="text" class="form-control" id="olymp-score" name="olymp_score" required>
        </div>
        <div class="mb-3">
            <label for="school" class="form-label">Выберите город</label>
            <select id="school" name="school_id" class="form-select" required>
                <option value="" disabled selected>— выберите школу —</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
</body>
</html>
@endsection
