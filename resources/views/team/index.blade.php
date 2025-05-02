@extends('layouts.app')

@section('title', 'Список команд')

@section('content')
    @php use App\Models\Team; @endphp

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список команд</h1>
            <a href="{{ route('team.create') }}" class="btn btn-sm btn-success">Создать команд</a>
            @if($teams->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название команды</th>
                            <th scope="col">Состав команды</th>
                            <th scope="col">Олимпиадный балл</th>
                            <th scope="col">Турнир</th>
                            <th scope="col" class="text-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td>{{ $team->id }}</td>
                                <td class="fw-semibold">{{ $team->name }}</td>
                                <td class="fw-semibold">
                                    @foreach($team->teamStudents as $teamStudent)
                                        {{$teamStudent->student->getFullFio()}} <br>
                                    @endforeach
                                </td>
                                <td class="fw-semibold">{{ $team->getOlympScore() }}</td>
                                <td class="fw-semibold">{{ $team->tournament->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('team.show', $team->id) }}" class="btn btn-sm btn-outline-primary">Просмотр</a>
                                    <a href="{{ route('team.edit', $team->id) }}" class="btn btn-sm btn-outline-warning">Изменить</a>

                                    <form action="{{ route('team.destroy', $team->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить эту команду?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    Пока нет ни одной команды.
                </div>
            @endif
        </div>
    </div>
@endsection
