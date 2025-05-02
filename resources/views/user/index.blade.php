@extends('layouts.app')

@section('title', 'Список пользователей')

@section('content')
    @php use App\Models\User; @endphp

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список пользователей</h1>
            <a href="{{ route('user.create') }}" class="btn btn-sm btn-success">Создать пользователя</a>
            @if($users->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Логин</th>
                            <th scope="col">Почта</th>
                            <th scope="col">Роль</th>
                            <th scope="col" class="text-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td class="fw-semibold">{{ $user->email }}</td>
                                <td class="fw-semibold">{{ (new App\Components\RoleDictionary())->get($user->role) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-warning">Изменить</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить этого участника?');">
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
                    Пока нет ни одного пользователя.
                </div>
            @endif
        </div>
    </div>
@endsection

