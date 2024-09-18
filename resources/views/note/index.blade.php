@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">Заметки</h2>
            <a href="{{ route('note.create') }}" class="btn btn-primary">Добавить</a>
        </div>

        <!-- Список заметок -->
        <div class="row">
            @if($notes->isEmpty())
                <div class="col-12">
                    <div class="col-12 mt-5 text-center">
                        <h3 style="color: grey;">У вас пока нет заметок...</h3>
                    </div>
                </div>
            @else
                @foreach($notes as $note)
                    <div data-note-id="{{ $note->id }}" class="col-md-4 mb-3 note-item">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $note->title }}</h5>
                                <p class="card-text note-block">
                                    {{ $note->content }}
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('note.show', $note) }}" class="btn btn-sm">
                                    <i class="fas fa-edit" style="color:grey"></i>
                                </a>
                                <button class="btn btn-sm" onclick="deleteNote({{ $note->id }}, this)">
                                    <i class="fas fa-trash-alt" style="color:grey"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

<script>
    function deleteNote(noteId, button) {
        var confirmation = confirm('Вы уверены, что хотите удалить эту заметку?');

        if (confirmation) {
            $.ajax({
                url: `/notes/${noteId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // добавляем токен
                },
                success: function (response) {
                    $(`.note-item[data-note-id='${noteId}']`).remove();
                },
                error: function (xhr) {
                    console.error('Произошла ошибка при удалении заметки.', xhr);
                }
            });
        }
    }
</script>

<style>
    .note-block {
        height: 150px; /* фиксированная высота блока */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 6; /* количество строк */
    }
</style>