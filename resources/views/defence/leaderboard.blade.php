@extends('layouts.app')

@section('title', 'Таблица результатов')

@section('content')
    <div class="container mt-5">
        <h1>Таблица: {{ $defence->name }}</h1>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Название защиты</th>
                <th>Очки</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($acts as $act)
                <tr>
                    <td>{{ $act->name }}</td>
                    <td>{{ $act->getTotalScore() }}</td>
                    <td>
                        <a href="{{ route('defence.score', $act->id) }}" class="btn btn-success">Выставление баллов</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <a href="{{ route('defence.show', $defence->id) }}" class="btn btn-secondary">Назад к защите</a>

    </div>

@endsection
