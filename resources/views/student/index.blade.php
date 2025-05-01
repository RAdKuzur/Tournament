@extends('layouts.app')

@section('title', 'Список школ')

@section('content')
    @php use \App\Models\Student; @endphp

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список участников</h1>
            <a href="{{ route('student.create') }}" class="btn btn-sm btn-success">Создать участника</a>
            @if($students->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Фамилия</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Отчество</th>
                            <th scope="col">Олимпиадный балл</th>
                            <th scope="col">Школа</th>
                            <th scope="col" class="text-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td class="fw-semibold">{{ $student->surname }}</td>
                                <td class="fw-semibold">{{ $student->name }}</td>
                                <td class="fw-semibold">{{ $student->patronymic }}</td>
                                <td class="fw-semibold">{{ $student->olymp_score }}</td>
                                <td class="fw-semibold">{{ $student->school->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('student.show', $student->id) }}" class="btn btn-sm btn-outline-primary">Просмотр</a>
                                    <a href="{{ route('student.edit', $student->id) }}" class="btn btn-sm btn-outline-warning">Изменить</a>

                                    <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить эту школу?');">
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
                    Пока нет ни одного участника.
                </div>
            @endif
        </div>
    </div>
@endsection
