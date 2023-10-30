<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        \App\Models\User::factory()->create([
            'name' => 'đạt đẹp trai',
            'email' => 'dat@gmail.com',
            'sdt'=>'0392751331',
            'quan' => 'Thủ Đức',
            'password' => bcrypt(123)
        ]);
    }
}
