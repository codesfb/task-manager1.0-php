<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Exibir lista de tarefas do usuário autenticado.
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->get();
        
        $categories = Category::where('user_id', auth()->id())->get();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    /**
     * Armazenar uma nova tarefa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Exibir formulário de edição de uma tarefa.
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::where('user_id', auth()->id())->get();

        return view('tasks.edit', compact('task', 'categories'));
    }

    /**
     * Atualizar uma tarefa existente.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'is_completed' => 'boolean',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Marcar tarefa como concluída.
     */
    public function toggleComplete(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->update(['is_completed' => !$task->is_completed]);

        return redirect()->route('tasks.index')->with('success', 'Status da tarefa atualizado!');
    }

    /**
     * Deletar uma tarefa.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa deletada com sucesso!');
    }
}
