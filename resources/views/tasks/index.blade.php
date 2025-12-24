<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tarefas</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="text-green-600 mb-4">{{ session('success') }}</div>
                @endif

                <h3 class="font-semibold mb-2">Criar tarefa</h3>
                <form method="POST" action="{{ route('tasks.store') }}" class="mb-6">
                    @csrf
                    <div class="mb-2">
                        <input name="title" placeholder="Título" class="border rounded px-2 py-1 w-full" value="{{ old('title') }}">
                        @error('title')<div class="text-red-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <select name="category_id" class="border rounded px-2 py-1 w-full">
                            <option value="">-- Categoria --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="text-red-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <textarea name="description" placeholder="Descrição" class="border rounded px-2 py-1 w-full">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
                    </div>
                </form>

                <h3 class="font-semibold mb-2">Minhas tarefas</h3>
                <ul class="space-y-3">
                    @forelse($tasks as $task)
                        <li class="border rounded p-3 flex justify-between items-start">
                            <div>
                                <div class="font-bold">{{ $task->title }} <span class="text-sm text-gray-500">({{ $task->category->name ?? 'Sem categoria' }})</span></div>
                                <div class="text-sm text-gray-700">{{ $task->description }}</div>
                                <div class="text-xs text-gray-500">Criado em {{ $task->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-1 rounded bg-yellow-600 text-white">Editar</a>

                                <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1 rounded {{ $task->is_completed ? 'bg-green-600 text-white' : 'bg-gray-200' }}">{{ $task->is_completed ? 'Concluída' : 'Marcar' }}</button>
                                </form>

                                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 text-white">Excluir</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-600">Nenhuma tarefa encontrada.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
