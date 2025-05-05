@php
    use App\Components\widget\DynamicFormWidget;
    /* @var $students */
@endphp
@extends('layouts.app')

@section('title', 'Участники личной защиты')

@section('content')
    <div class="container mt-5">
        <h1>Информация о команде: {{ $team->name }}</h1>
        @if(count($participants))
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ФИО</th>
                    <th scope="col" class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($participants as $participant)
                    <tr>
                        <td>{{ $participant->id }}</td>
                        <td class="fw-semibold">{{ $participant->student->getFullFio() }}</td>
                        <td class="text-end">
                            <form action="{{ route('defence.delete-defence-participant', $participant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить этого участника?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <form method="POST" action="{{ route('defence.add-team-participant-post', $team->id) }}">
            @csrf
            @php
                $widget = new DynamicFormWidget();
                $widget->attribute = [
                    [
                       'name' => 'participants',
                       'label' => 'ФИО участника',
                       'data' => $students,
                       'method' => 'getFullFio'
                    ]
                ];
                echo $widget->render(DynamicFormWidget::DROPDOWN);
            @endphp
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
        <a href="{{ route('defence.act-defence', $team->defence_id) }}" class="btn btn-warning">Вернуться к командам</a>
    </div>
@endsection
