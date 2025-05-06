@extends('layouts.app')

@section('title', 'Таблица результатов')

@section('content')
    <div class="container mt-5">
        <h1>Таблица: {{ $defence->name }}</h1>
        <div class="container mt-5">
            <div id="score-table">
                @include('defence.leaderboard-table', ['acts' => $acts, 'defence' => $defence])
            </div>
        </div>
        <a href="{{ route('defence.show', $defence->id) }}" class="btn btn-secondary mt-3">Назад к защите</a>
    </div>

@endsection
