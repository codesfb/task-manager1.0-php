<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; 
use App\Models\User;        

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Pega o primeiro usuário cadastrado
        $user = User::first();

        if ($user) {
            $categories = ['Trabalho', 'Estudos', 'Pessoal', 'Saúde'];

            foreach ($categories as $category) {
                Category::create([
                    'name' => $category,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}