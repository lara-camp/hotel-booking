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
            'name' => 'Standard Single',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Standard Double',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Deluxe Single',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Deluxe Double',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Superior Double',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Suite',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Family Room',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Connecting Room',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('room_types')->insert([
            'name' => 'Business Room',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
