<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MakersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('makers')->insert([
            [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
                'name'=> 'Coca-Cola',
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
                'name'=> 'サントリー',
            ],
            [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
                'name'=> 'キリン',
            ],
        ]);
    }
}
