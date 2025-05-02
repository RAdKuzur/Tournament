@extends('layouts.app')

@section('title', 'Команда')

@section('content')
    <div class="container mt-5">
        <h1>Информация об команде: {{ $team->name }}</h1>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Школа</th>
                <th>Турнир</th>
                <th>Состав команды</th>
                <th>Общий балл</th>
            </tr>
            <tr>
                <td>{{ $team->id }}</td>
                <td>{{ $team->name }}</td>
                <td>{{ $team->school->name }}</td>
                <td>{{ $team->tournament->name }}</td>
                <td>
                    @foreach($team->teamStudents as $teamStudent)
                        {{$teamStudent->student->getFullFio()}} <br>
                    @endforeach
                </td>
                <td>{{ $team->getOlympScore() }}</td>
            </tr>
        </table>

        <a href="{{ route('team.index') }}" class="btn btn-secondary">Назад к списку</a>
        <a href="{{ route('team.edit', $team->id) }}" class="btn btn-warning">Изменить</a>
    </div>
@endsection
