@extends('layouts.app')

@section('title', 'Защиты')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Защиты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Введите название защиты</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('defence.store') }}">
        @csrf
        <div class="mb-3">
            <label for="defence-name" class="form-label">Название защиты</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-6">
            <label for="date" class="form-label">Дата защиты</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Выберите тип защиты</label>
            <select id="type" name="type" class="form-select" required>
                <option value="" disabled selected>— выберите тип защиты —</option>
                @foreach($types as $i => $type)
                    <option value="{{ $i }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
</body>
</html>
@endsection
