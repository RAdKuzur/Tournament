@extends('layouts.app')

@section('title', 'Личный зачёт')

@section('content')
    @php use App\Models\Tournament;
    $participants = collect();
    foreach ($teams as $team) {
        foreach ($team->teamStudents as $participant) {
            $participants->push([
                'id' => $participant->id,
                'fio' => $participant->student->getFullFio(),
                'score' => $participant->getScores(),
                'team_name' => $team->name
            ]);
        }
    }
    $sortedParticipants = $participants->sortByDesc('score');

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
                        <th scope="col">Команда</th>
                        <th scope="col" class="text-end">Общий балл</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sortedParticipants as $participant)
                        <tr>
                            <td>{{ $participant['id'] }}</td>
                            <td class="fw-semibold">{{ $participant['fio'] }}</td>
                            <td> {{ $participant['team_name'] }}</td>
                            <td class="text-end">
                                {{ $participant['score'] }}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
