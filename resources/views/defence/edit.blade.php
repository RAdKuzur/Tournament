@extends('layouts.app')

@section('title', 'Редактировать защиту')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Редактировать защиту</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Редактировать защиту</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('defence.update', $defence->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Название защиты</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $defence->name) }}" required>
        </div>
        <div class="col-md-6">
            <label for="date" class="form-label">Дата защиты</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $defence->date) }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Выберите тип защиты</label>
            <select id="type" name="type" class="form-select" required>
                <option value="" disabled>— выберите тип защиты —</option>
                @foreach($types as $i => $type)
                    <option value="{{ $i }}" {{ old('type', $defence->type) == $i ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
</div>
</body>
</html>
@endsection
