<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Conta;

class ContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Conta::where('nome', 'Energia')->first()){
            Conta::create([
                'nome' => 'Energia',
                'valor' => '147.52',
                'vencimento' => '2024-10-23',
            ]);
        }

        if(!Conta::where('nome', 'Internet')->first()){
            Conta::create([
                'nome' => 'Internet',
                'valor' => '147.52',
                'vencimento' => '2024-10-23',
            ]);
        }

        if(!Conta::where('nome', 'Cartão')->first()){
            Conta::create([
                'nome' => 'Cartão',
                'valor' => '147.52',
                'vencimento' => '2024-10-23',
            ]);
        }

        if(!Conta::where('nome', 'Condominio')->first()){
            Conta::create([
                'nome' => 'Condominio',
                'valor' => '147.52',
                'vencimento' => '2024-10-23',
            ]);
        }
    }
}
