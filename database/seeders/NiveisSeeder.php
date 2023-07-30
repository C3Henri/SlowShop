<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NiveisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('niveis')->insert([
            [
                'id' => 1,
                'nivel' => 1,
                'desconto' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'nivel' => 2,
                'desconto' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'nivel' => 3,
                'desconto' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
