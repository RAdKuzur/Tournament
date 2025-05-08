@extends('layouts.app')

@section('title', 'Матч')

@section('content')
    @php use \App\Models\Game; @endphp
    <div class="table-responsive">
        <h2>Команда {{$game->firstTeam->name}}</h2>
        <table class="table table-hover align-middle">
            <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ФИО участника</th>
                <th scope="col">Текущий балл</th>
                <th scope="col" class="text-end">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($game->firstTeam->teamStudents as $participant)
                <tr>
                    <td>{{ $participant->id }}</td>
                    <td class="fw-semibold">{{ $participant->student->getFullFio() }}</td>
                    <td class="fw-semibold">{{ $participant->getGameScore($game->id) }}</td>
                    <td>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::PLUS, 1, $game->id]) }}" class="btn btn-success">+1</a>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::PLUS, 3, $game->id]) }}" class="btn btn-success">+3</a>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::MINUS, 1, $game->id]) }}" class="btn btn-danger">-1</a>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::MINUS, 3, $game->id]) }}" class="btn btn-danger">-3</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <h2>Команда {{$game->secondTeam->name}}</h2>
        <table class="table table-hover align-middle">
            <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ФИО участника</th>
                <th scope="col">Текущий балл</th>
                <th scope="col" class="text-end">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($game->secondTeam->teamStudents as $participant)
                <tr>
                    <td>{{ $participant->id }}</td>
                    <td class="fw-semibold">{{ $participant->student->getFullFio() }}</td>
                    <td class="fw-semibold">{{ $participant->getGameScore($game->id) }}</td>
                    <td>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::PLUS, 1, $game->id]) }}" class="btn btn-success">+1</a>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::PLUS, 3, $game->id]) }}" class="btn btn-success">+3</a>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::MINUS, 1, $game->id]) }}" class="btn btn-danger">-1</a>
                        <a href="{{ route('game.change-score', [$participant->id, \App\Models\TeamStudentParticipant::MINUS, 3, $game->id]) }}" class="btn btn-danger">-3</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('draw.index', [$game->tournament->id]) }}" class="btn btn-success">Вернуться к жеребьёвке</a>
    </div>
@endsection
