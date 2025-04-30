@extends('layouts.app')

@section('title', 'Список школ')

@section('content')
    @php use App\Models\School; @endphp

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список школ</h1>
            <a href="{{ route('school.create') }}" class="btn btn-sm btn-success">Создать школу</a>
            @if($schools->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название школы</th>
                            <th scope="col" class="text-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($schools as $school)
                            <tr>
                                <td>{{ $school->id }}</td>
                                <td class="fw-semibold">{{ $school->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('school.show', $school->id) }}" class="btn btn-sm btn-outline-primary">Просмотр</a>
                                    <a href="{{ route('school.edit', $school->id) }}" class="btn btn-sm btn-outline-warning">Изменить</a>

                                    <form action="{{ route('school.destroy', $school->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить эту школу?');">
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
