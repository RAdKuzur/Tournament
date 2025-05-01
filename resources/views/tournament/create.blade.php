@extends('layouts.app')

@section('title', 'Создание мероприятия')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Форма мероприятия</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validateDates() {
            const beginDate = document.getElementById('begin-date');
            const finishDate = document.getElementById('finish-date');
            if (beginDate.value && finishDate.value) {
                if (new Date(beginDate.value) > new Date(finishDate.value)) {
                    alert('Дата начала не может быть позже даты окончания!');
                    beginDate.value = '';
                    finishDate.value = '';
                    beginDate.focus();
                }
            }
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h1>Введите название мероприятия(турнира)</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('tournament.store') }}">
        @csrf
        <div class="mb-3">
            <label for="tournament-name" class="form-label">Название мероприятия (турнира)</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="begin-date" class="form-label">Дата начала мероприятия (турнира)</label>
                <input type="date" class="form-control" id="begin-date" name="begin_date"
                       onchange="validateDates()" required>
            </div>
            <div class="col-md-6">
                <label for="finish-date" class="form-label">Дата окончания мероприятия (турнира)</label>
                <input type="date" class="form-control" id="finish-date" name="finish_date"
                       onchange="validateDates()" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="tournament-type" class="form-label">Выберите тип жеребьёвки</label>
            <select id="tournament-type" name="type" class="form-select" required>
                <option value="" disabled selected>— выберите тип жеребьёвки —</option>
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
