@extends('layouts.app')

@section('title', 'Защита')

@section('content')
    <div class="container mt-5">
        <h1>Информация о защите: {{ $defence->name }}</h1>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название защиты</th>
                <th>Дата защиты</th>
                <th>Тип защиты</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $defence->id }}</td>
                <td>{{ $defence->name }}</td>
                <td>{{ \Carbon\Carbon::parse($defence->date)->format('d.m.Y') }}</td>
                <td>{{ (new \App\Components\DefenceTypeDictionary())->get($defence->type) }}</td>
            </tr>
            </tbody>
        </table>

        <a href="{{ route('defence.index') }}" class="btn btn-secondary">Назад к списку</a>
        <a href="{{ route('defence.edit', $defence->id) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('defence.act-defence', $defence->id) }}" class="btn btn-primary">Добавить участников</a>
    </div>

@endsection
