@extends('layouts.app')

@section('title', 'Восстановление доступа')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Восстановление доступа</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Восстановление доступа</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('auth.reset-password') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Введите почту для восстановления доступа</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Восстановить доступ</button>
    </form>
</div>
</body>
</html>
@endsection
