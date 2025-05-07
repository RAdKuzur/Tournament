@extends('layouts.app')

@section('title', 'Список игр')

@section('content')
    @php use \App\Models\Game; @endphp

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="h4 mb-4">Список игр</h1>

            @if($games->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">Команда 1</th>
                            <th scope="col">Счет 1</th>
                            <th scope="col">Счет 2</th>
                            <th scope="col">Команда 2</th>
                            @can('manage-games')
                                <th scope="col" class="text-end">Действия</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($games as $game)
                            <tr>
                                <td class="fw-semibold">{{ $game->firstTeam->name }}</td>
                                <td>{{ $game->getFirstTeamScore() }}</td>
                                <td>{{ $game->getSecondTeamScore() }}</td>
                                <td class="fw-semibold">{{ $game->secondTeam->name }}</td>
                                @can('manage-games')
                                    <td class="text-end">
                                        <a href="{{ route('draw.edit-score', $game->id) }}" class="btn btn-sm btn-outline-primary">
                                            Изменить счет
                                        </a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('draw.conclude-round', ) }}" class="btn btn-sm btn-outline-primary">
                        Изменить счет
                    </a>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    Пока нет запланированных игр.
                </div>
            @endif
        </div>
    </div>
@endsection
