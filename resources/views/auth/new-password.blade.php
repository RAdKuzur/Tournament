@extends('layouts.app')

@section('title', 'Новый пароль')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Восстановление доступа</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Новый пароль</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('auth.update-password', $id) }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Введите новый пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Применить пароль</button>
    </form>
</div>
</body>
</html>
@endsection
