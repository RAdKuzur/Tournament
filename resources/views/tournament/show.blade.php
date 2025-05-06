@extends('layouts.app')

@section('title', 'Мероприятие')

@section('content')
    <div class="container mt-5">
        <h1>Информация о мероприятии (турнире): {{ $tournament->name }}</h1>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Дата начала</th>
                <th>Дата окончания</th>
                <th>Тип жеребьёвки</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $tournament->id }}</td>
                <td>{{ $tournament->name }}</td>
                <td>{{ \Carbon\Carbon::parse($tournament->begin_date)->format('d.m.Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($tournament->finish_date)->format('d.m.Y') }}</td>
                <td>{{ (new \App\Components\TournamentTypeDictionary())->get($tournament->type) }}</td>
            </tr>
            </tbody>
        </table>

        <a href="{{ route('tournament.index') }}" class="btn btn-secondary">Назад к списку</a>
        <a href="{{ route('tournament.edit', $tournament->id) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('draw.index', $tournament->id) }}" class="btn btn-success">Перейти к жеребьевке</a>
    </div>
@endsection
