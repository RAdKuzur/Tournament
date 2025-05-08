@extends('layouts.app')

@section('title', 'Командный зачёт')

@section('content')
    @php use App\Models\Tournament;
    @endphp
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список команд</h1>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название команды</th>
                            <th scope="col" class="text-end">Общий балл</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td>{{ $team->id }}</td>
                                <td class="fw-semibold">{{ $team->name }}</td>
                                <td class="text-end">
                                    {{ $team->getTournamentScore() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endsection
