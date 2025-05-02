@extends('layouts.app')

@section('title', 'Создание пользователя')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Форма пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Создание пользователя</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('user.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Логин</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Почта</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Выберите роль пользователя</label>
            <select id="role" name="role" class="form-select" required>
                <option value="" disabled selected>— выберите роль пользователя —</option>
                @foreach($roles as $i => $role)
                    <option value="{{ $i }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="text" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
</body>
</html>
@endsection
