@extends('layouts.app')

@section('title', 'Список защит')

@section('content')
    @php use App\Models\Defence; @endphp

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список защит</h1>
            <a href="{{ route('defence.create') }}" class="btn btn-sm btn-success">Создать школу</a>
            @if($defences->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название защиты</th>
                            <th scope="col">Тип защиты защиты</th>
                            <th scope="col" class="text-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($defences as $defence)
                            <tr>
                                <td>{{ $defence->id }}</td>
                                <td class="fw-semibold">{{ $defence->name }}</td>
                                <td class="fw-semibold">{{ (new App\Components\DefenceTypeDictionary())->get($defence->type) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('defence.show', $defence->id) }}" class="btn btn-sm btn-outline-primary">Просмотр</a>
                                    <a href="{{ route('defence.edit', $defence->id) }}" class="btn btn-sm btn-outline-warning">Изменить</a>

                                    <form action="{{ route('defence.destroy', $defence->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить эту защиту?');">
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
                    Пока нет ни одной школы.
                </div>
            @endif
        </div>
    </div>
@endsection
