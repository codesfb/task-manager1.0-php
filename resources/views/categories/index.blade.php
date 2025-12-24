<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="text-green-600 mb-4">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('categories.store') }}" class="mb-4">
                    @csrf
                    <div class="flex space-x-2">
                        <input name="name" placeholder="Nova categoria" class="border rounded px-2 py-1 w-full" value="{{ old('name') }}">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Criar</button>
                    </div>
                    @error('name')<div class="text-red-600">{{ $message }}</div>@enderror
                </form>

                <ul class="space-y-2">
                    @forelse($categories as $category)
                        <li class="flex justify-between items-center border rounded px-3 py-2">
                            <div>{{ $category->name }}</div>
                            <div class="flex items-center space-x-2">
                                <form method="POST" action="{{ route('categories.update', $category) }}" class="hidden" id="edit-cat-{{ $category->id }}">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 text-white">Excluir</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-600">Nenhuma categoria encontrada.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
