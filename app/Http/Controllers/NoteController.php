<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        // Получаем заметки текущего пользователя
        $notes = auth()->user()->notes;
        return view('note.index', compact('notes'));
    }

    public function create()
    {
        return view('note.create_edit_form', ['isEditing' => false]);

    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Добавляем идентификатор пользователя к данным
        $data['user_id'] = auth()->id();

        $note = Note::create($data);
        return response()->json($note, 201);
    }

    public function show(Note $note)
    {
        return view('note.create_edit_form', compact('note'), ['isEditing' => true]);
    }

    public function update(Note $note)
    {
        $data = request()->validate([
            'title' => 'string|max:255',
            'content' => 'string',
        ]);

        $note->update($data);

        return response()->json($note);
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(['message' => 'Заметка успешно удалена'], 204);
    }
}
