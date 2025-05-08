@extends('layouts.app')

@section('title', 'Личный зачёт')

@section('content')
    @php use App\Models\Tournament;
    @endphp
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список участников турнира</h1>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ФИО участника</th>
                        <th scope="col" class="text-end">Общий балл</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teams as $team)
                        @foreach($team->teamStudents as $participant)
                            <tr>
                                <td>{{ $participant->id }}</td>
                                <td class="fw-semibold">{{ $participant->student->getFullFio() }}</td>
                                <td class="text-end">
                                    {{ $participant->getScores() }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
