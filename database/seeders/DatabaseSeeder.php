<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\NiveisSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(NiveisSeeder::class);
        // $this->call(CategoriasSeeder::class);
        // $this->call(ProdutosSeeder::class);
        // $this->call(CategoriasDescontosSeeder::class);
        // $this->call(FuncionariosSeeder::class);
        // $this->call(ComprasSeeder::class);
        // $this->call(ComprasProdutosSeeder::class);
    }
}
