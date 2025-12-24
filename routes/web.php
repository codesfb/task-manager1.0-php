<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

// 1. Rota Pública
Route::get('/', function () {
    return view('welcome');
});

// 2. Grupo de Rotas Protegidas (Apenas usuários logados)
Route::middleware('auth')->group(function () {
    
    // Atalho: O Dashboard agora é a própria listagem de tarefas
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');

    // Perfil do Usuário (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Recurso: Tarefas (Tasks) com validação de propriedade
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        
        // Validação: A tarefa deve pertencer ao usuário autenticado
        Route::middleware(['can:view,task'])->group(function () {
            Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
            Route::patch('/{task}', [TaskController::class, 'update'])->name('update');
            Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
            Route::patch('/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('toggle');
        });
    });

    // Recurso: Categorias (Categories) com validação de propriedade
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        
        // Validação: A categoria deve pertencer ao usuário autenticado
        Route::middleware(['can:view,category'])->group(function () {
            Route::patch('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__.'/auth.php';
