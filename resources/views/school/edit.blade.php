@extends('layouts.app')

@section('title', 'Список школ')

@section('content')
    <!DOCTYPE html>
    <html>
    <head>
        <title>Редактировать школу</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
        <h1>Редактировать школу</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Форма обновления -->
        <form method="POST" action="{{ route('school.update', $school->id) }}">
            @csrf
            @method('PUT') <!-- Для PATCH/PUT запроса -->

            <div class="mb-3">
                <label for="school-name" class="form-label">Название школы</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $school->name) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('school.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
    </body>
    </html>
@endsection
