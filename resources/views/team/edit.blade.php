@extends('layouts.app')

@section('title', 'Редактирование команды')
@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Редактирование команды</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Выберите участников',
                allowClear: true
            });
        });
    </script>
</head>
<body>
<div class="container mt-5">
    <h1>Редактирование команды</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('team.update', $team->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="team-name" class="form-label">Название команды</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $team->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="tournament" class="form-label">Турнир</label>
            <input type="text" class="form-control" value="{{$team->tournament->name}}" readonly/>

        </div>
        <div class="mb-3">
            <label for="school" class="form-label">Школа</label>
            <input id="school" class="form-control" type="text" value="{{$team->school->name}}" readonly/>
        </div>
        <div class="mb-3">
            <label for="students">Выберите участников:</label>
            <select name="students[]" multiple class="form-control select2">
                @foreach($students as $student)
                    <option value="{{ $student->id }}"
                        {{ in_array($student->id, $team->students->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $student->getFullFio() }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Сохранить изменения</button>
    </form>
</div>
</body>
</html>
@endsection
