@extends('layouts.app')

@section('title', 'Список мероприятий')

@section('content')
    @php use App\Models\Tournament; @endphp

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список мероприятий</h1>
            <a href="{{ route('tournament.create') }}" class="btn btn-sm btn-success">Создать мероприятие</a>
            @if($tournaments->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название мероприятия</th>
                            <th scope="col" class="text-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tournaments as $tournament)
                            <tr>
                                <td>{{ $tournament->id }}</td>
                                <td class="fw-semibold">{{ $tournament->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('tournament.show', $tournament->id) }}" class="btn btn-sm btn-outline-primary">Просмотр</a>
                                    <a href="{{ route('tournament.edit', $tournament->id) }}" class="btn btn-sm btn-outline-warning">Изменить</a>

                                    <form action="{{ route('tournament.destroy', $tournament->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить это мероприятие?');">
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
                    Пока нет ни одного мероприятия.
                </div>
            @endif
        </div>
    </div>
@endsection
