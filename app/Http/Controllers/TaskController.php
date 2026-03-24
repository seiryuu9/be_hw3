<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(Note $note)
    {
        return response()->json($note->tasks, Response::HTTP_OK);
    }

    public function store(Request $request, Note $note)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_done' => ['sometimes', 'boolean'],
            'due_at' => ['nullable', 'date'],
        ]);

        $task = $note->tasks()->create($validated);

        return response()->json([
            'message' => 'Úloha bola úspešne vytvorená.',
            'task' => $task,
        ], Response::HTTP_CREATED);
    }

    public function show(Note $note, Task $task)
    {
        if ($task->note_id !== $note->id) {
            return response()->json(['message' => 'Úloha nepatrí k tejto poznámke.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($task, Response::HTTP_OK);
    }

    public function update(Request $request, Note $note, Task $task)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_done' => ['sometimes', 'boolean'],
            'due_at' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Úloha bola úspešne aktualizovaná.',
            'task' => $task,
        ], Response::HTTP_OK);
    }

    public function destroy(Note $note, Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Úloha bola úspešne vymazaná.'
        ], Response::HTTP_OK);
    }

}
