@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('note.index') }}" class="mb-3 text-primary">
            <i class="fas fa-arrow-left"></i>
            {{ $isEditing ? 'Назад' : 'Все заметки' }}
        </a>
        <h2 class="my-3" style="color: dimgray">{{ $isEditing ? 'Редактирование' : 'Добавление'}}</h2>

        <form id="noteForm" action="{{ $isEditing ? route('note.update', $note->id) : route('note.store') }}"
              method="post">
            @csrf
            <div class="form-group">
                <label for="noteTitle">Заголовок</label>
                <input type="text" class="form-control" id="noteTitle" name="title"
                       value="{{ $isEditing ? $note->title : '' }}" required>
            </div>
            <div class="form-group">
                <label for="noteContent">Описание</label>
                <textarea class="form-control" id="noteContent" style="height: 150px;" name="content"
                          required>{{ $isEditing ? $note->content : '' }}</textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit"
                        class="btn btn-primary mr-2">{{ $isEditing ? 'Сохранить изменения' : 'Сохранить' }}</button>
                <div id="notification" style="display: none;" class="alert alert-success mb-0" role="alert"></div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#noteForm').on('submit', function (e) {
                e.preventDefault(); // предотвращаем стандартное поведение формы

                let isEditing = {{ json_encode($isEditing) }};

                $.ajax({
                    url: $(this).attr('action'),
                    method: isEditing ? 'PUT' : 'POST',
                    data: $(this).serialize() + '&_token={{ csrf_token() }}',
                    success: function (response) {
                        $('#notification')
                            .text(isEditing ? 'Заметка успешно обновлена' : 'Заметка успешно добавлена')
                            .addClass('show') // Показать уведомление
                            .fadeIn()
                            .delay(1500)
                            .fadeOut(function () {
                                $(this).removeClass('show');
                            });
                        if (!isEditing) $('#noteForm')[0].reset(); // Очищаем поля формы
                    },
                    error: function () {
                    }
                });
            });
        });
    </script>
@endsection