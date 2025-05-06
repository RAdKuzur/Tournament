@extends('layouts.app')

@section('title', 'Выставление баллов')

@section('content')
    <div class="container mt-5">
        <h1>Таблица: {{ $actDefence->defence->name }}</h1>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ФИО участника</th>
                <th>Очки</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($participants as $participant)
                <tr>
                    <td>{{ $participant->student->getFullFio() }}</td>
                    <td>{{ $participant->score }}</td>
                    <td>
                        <a href="{{ route('defence.change-score', [$participant->id, \App\Models\DefenceParticipant::PLUS, 1]) }}" class="btn btn-success">+1</a>
                        <a href="{{ route('defence.change-score', [$participant->id, \App\Models\DefenceParticipant::PLUS, 3]) }}" class="btn btn-success">+3</a>
                        <a href="{{ route('defence.change-score', [$participant->id, \App\Models\DefenceParticipant::MINUS, 1]) }}" class="btn btn-danger">-1</a>
                        <a href="{{ route('defence.change-score', [$participant->id, \App\Models\DefenceParticipant::MINUS, 3]) }}" class="btn btn-danger">-3</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('defence.leaderboard', $participant->actDefence->defence->id)}}" class="btn btn-primary">Назад к таблице лидеров</a>
    </div>

@endsection
