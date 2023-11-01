<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'HoTen'=>'đạt',
            'quan'=>'quan 1',
            'sdt'=>"0392751331",
            'email'=>'dat321@gmail.com',
            'password'=>bcrypt('03121998'),
            'vaiTro' => 0
        ]);
    }
}
