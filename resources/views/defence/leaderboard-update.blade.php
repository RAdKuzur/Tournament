<script>
setInterval(function () {
    fetch("{{ route('defence.leaderboard-update', $defence->id) }}")
    .then(response => response.text())
            .then(html => {
        document.getElementById('score-table').innerHTML = html;
    })
            .catch(error => console.error('Ошибка обновления таблицы:', error));
    }, 500); // обновление каждые 5 секунд
</script>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Название защиты</th>
        <th>Очки</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @foreach($acts as $act)
        <tr>
            <td>{{ $act->name }}</td>
            <td>{{ $act->getTotalScore() }}</td>
            <td>
                <a href="{{ route('defence.score', $act->id) }}" class="btn btn-success">Выставление баллов</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
