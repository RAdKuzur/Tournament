@extends('layouts.app')

@section('title', 'Список игр')

@section('content')
    @php use \App\Models\Game; @endphp

    <div class="card shadow-sm border-0">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-body">
            @if($games->count())
                <div class="table-responsive" id = "game-table">
                    @include('draw.games-table', [
                        'games' => $games,
                        'tournament' => $tournament,
                    ])
                </div>
            @else
                <div class="alert alert-info mb-0">
                    Пока нет запланированных игр.
                </div>
                @can('manage-games')
                    <div class="text-center pt-4">
                        <a href="{{ route('draw.start-tournament', $tournament->id ) }}" class="btn btn-sm btn-outline-primary">
                            Начать турнир
                        </a>
                    </div>
                @endcan

            @endif
        </div>
    </div>
@endsection
