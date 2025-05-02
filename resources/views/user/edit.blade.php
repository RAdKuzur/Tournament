@extends('layouts.app')

@section('title', 'Редактирование пользователя')

@section('content')
    <div class="container mt-5">
        <h1>Редактирование пользователя</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Логин</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Выберите роль пользователя</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="" disabled>— выберите роль пользователя —</option>
                    @foreach($roles as $i => $role)
                        <option value="{{ $i }}" {{ $user->role == $i ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль (если нужно сменить)</label>
                <input type="text" class="form-control" id="password" name="password" placeholder="Оставьте пустым для сохранения текущего">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
