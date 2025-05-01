@extends('layouts.app')

@section('title', 'Школа')

@section('content')
    <div class="container mt-5">
        <h1>Информация о школе: {{ $school->name }}</h1>

        <div class="mb-3">
            <strong>ID:</strong> {{ $school->id }}
            <strong>Название учреждения:</strong> {{ $school->name }}
        </div>

        <a href="{{ route('school.index') }}" class="btn btn-secondary">Назад к списку</a>
        <a href="{{ route('school.edit', $school->id) }}" class="btn btn-warning">Изменить</a>
    </div>
@endsection
