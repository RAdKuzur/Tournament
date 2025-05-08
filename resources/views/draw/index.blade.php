@extends('layouts.app')

@section('title', 'Список игр')

@section('content')
    @php use \App\Models\Game; @endphp

    <div class="card shadow-sm border-0">
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
            @endif
        </div>
    </div>
@endsection
