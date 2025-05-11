@php use App\Components\widget\DynamicFormWidget; @endphp
@extends('layouts.app')

@section('title', 'Участники командной защиты')

@section('content')
    <div class="container mt-5">
        <h1>Информация о командной защите: {{ $defence->name }}</h1>
        @if (count($actDefences))
        <table class="table table-hover align-middle">
            <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название команды</th>
                <th scope="col">Защита</th>
                <th scope="col">Участники</th>
                <th scope="col" class="text-end">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($actDefences as $act)
                <tr style="background-color: {{ (new \App\Components\ColorDictionary())->getColor($act->color) }} !important;">
                    <td style="background-color: inherit !important;">{{ $act->id }}</td>
                    <td class="fw-semibold" style="background-color: inherit !important;">{{ $act->name }}</td>
                    <td class="fw-semibold" style="background-color: inherit !important;">{{ $defence->name }}</td>
                    <td class="fw-semibold" style="background-color: inherit !important;">
                        @php
                            foreach($act->participants as $participant) {
                                echo $participant->student->getFullFio() . '<br>';
                            }
                        @endphp
                    </td>
                    <td class="text-end" style="background-color: inherit !important;">
                        <a href="{{ route('defence.change-color', $participant->actDefence->id) }}" class="btn btn-sm btn-outline-primary">Изменить цвет</a>
                        <a href="{{ route('defence.add-team-participant', $act->id) }}" class="btn btn-sm btn-outline-primary">Добавить участников</a>
                        <form action="{{ route('defence.delete-act-participant', $act->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить эту команду?');">
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
        <form method="POST" action="{{ route('defence.act-defence', $defence->id) }}">
            @csrf
            @php
                $widget = new DynamicFormWidget();
                $widget->attribute = [
                    [
                       'name' => 'team',
                       'label' => 'Название команды',
                       'type' => 'text'
                    ]
                ];
                echo $widget->render();
            @endphp
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
        <a href="{{ route('defence.show', $defence->id) }}" class="btn btn-warning">Вернуться к защите</a>
    </div>

@endsection

