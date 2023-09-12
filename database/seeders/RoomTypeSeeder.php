<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_types')->insert([
            'title' => 'Standard Single',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'title' => 'Standard Double',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'title' => 'Deluxe Single',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'title' => 'Deluxe Double',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'title' => 'Superior Double',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
