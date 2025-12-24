<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Tarefa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Título</label>
                        <input name="title" class="border rounded px-3 py-2 w-full" value="{{ old('title', $task->title) }}">
                        @error('title')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Categoria</label>
                        <select name="category_id" class="border rounded px-3 py-2 w-full">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Descrição</label>
                        <textarea name="description" class="border rounded px-3 py-2 w-full" rows="4">{{ old('description', $task->description) }}</textarea>
                        @error('description')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_completed" class="rounded" {{ old('is_completed', $task->is_completed) ? 'checked' : '' }}>
                            <span class="ms-2 text-gray-700">Marcar como concluída</span>
                        </label>
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
                        <a href="{{ route('tasks.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
