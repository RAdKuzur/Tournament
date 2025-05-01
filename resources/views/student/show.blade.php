@extends('layouts.app')

@section('title', 'Школа')

@section('content')
    <div class="container mt-5">
        <h1>Информация об участнике: {{ $student->getFullFio() }}</h1>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Олимпиадный балл</th>
                <th>Образовательное учреждение</th>
            </tr>
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->surname }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->patronymic }}</td>
                <td>{{ $student->olymp_score }}</td>
                <td>{{ $student->school->name }}</td>
            </tr>
        </table>

        <a href="{{ route('student.index') }}" class="btn btn-secondary">Назад к списку</a>
        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-warning">Изменить</a>
    </div>
@endsection
