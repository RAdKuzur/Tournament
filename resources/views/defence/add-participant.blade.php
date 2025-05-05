@extends('layouts.app')

@section('title', 'Участники защит')

@section('content')
    <div class="container mt-5">
        <h1>Информация о защите: {{ $defence->name }}</h1>
        <form method="POST" action="{{ route('defence.add-participant', $defence->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary">Сохранить участников</button>
        </form>
        <a href="{{ route('defence.show', $defence->id) }}" class="btn btn-warning">Вернуться к защите</a>
    </div>

@endsection

