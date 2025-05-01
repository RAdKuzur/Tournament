@extends('layouts.app')

@section('title', 'Создание школы')

@section('content')
    <!DOCTYPE html>
    <html>
    <head>
        <title>Форма школы</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
        <h1>Введите название школы</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('school.store') }}">
            @csrf
            <div class="mb-3">
                <label for="school-name" class="form-label">Название школы</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
    </body>
    </html>
@endsection
