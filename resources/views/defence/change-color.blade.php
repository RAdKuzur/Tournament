@php use App\Components\widget\DynamicFormWidget; @endphp
@extends('layouts.app')

@section('title', 'Участники командной защиты')

@section('content')
    <div class="container mt-5">
        <h1>Информация о цвете командной защиты: {{ $actDefence->defence->name }}</h1>
        <form method="POST" action="{{ route('defence.change-color-post', $actDefence->id) }}">
            @csrf
            <div class="mb-3">
                <label for="color" class="form-label">Выберите цвет</label>
                <select id="color" name="color" class="form-select" required>
                    <option value="" disabled>— выберите цвет —</option>
                    @foreach($colors as $i => $color)
                        <option value="{{ $i }}"
                            {{ old('school_id', $actDefence->color) == $i ? 'selected' : '' }}>
                            {{ $color }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Изменить цвет</button>
        </form>
    </div>
@endsection

