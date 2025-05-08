<script>
    setInterval(function () {
        fetch("{{ route('draw.games-table', $tournament->id) }}")
            .then(response => response.text())
            .then(html => {
                document.getElementById('game-table').innerHTML = html;
            })
            .catch(error => console.error('Ошибка обновления таблицы:', error));
    }, 1000); // обновление каждые 5 секунд
</script>
<h1 class="h4 mb-4">Список игр. Тур №{{$tournament->current_tour}}</h1>
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
                    <a href="{{ route('game.index', $game->id) }}" class="btn btn-sm btn-outline-primary">
                        Изменить счет
                    </a>
                </td>
            @endcan
        </tr>
    @endforeach
    </tbody>
</table>
<a href="{{ route('draw.next-round', $tournament->id ) }}" class="btn btn-sm btn-outline-primary">
    Начать жеребьёвку тура №{{$tournament->current_tour + 1}}
</a>
