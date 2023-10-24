<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            'room_number' => '121',
            'room_type_id' => 1,
            'bed_type' => 'Single',
            'number_of_bed' => 1,
            'price' => 40000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'room_number' => '122',
            'room_type_id' => 2,
            'bed_type' => 'Double',
            'number_of_bed' => 1,
            'price' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'room_number' => '123',
            'room_type_id' => 3,
            'bed_type' => 'Single',
            'number_of_bed' => 1,
            'price' => 800000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'room_number' => '124',
            'room_type_id' => 4,
            'bed_type' => 'Double',
            'number_of_bed' => 1,
            'price' => 100000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'room_number' => '125',
            'room_type_id' => 5,
            'bed_type' => 'Double',
            'number_of_bed' => 1,
            'price' => 150000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rooms')->insert([
          'room_number' => '126',
          'room_type_id' => 5,
          'bed_type' => 'Double',
          'number_of_bed' => 1,
          'price' => 150000,
          'created_at' => now(),
          'updated_at' => now(),
      ]);

      DB::table('rooms')->insert([
        'room_number' => '127',
        'room_type_id' => 5,
        'bed_type' => 'Thriple',
        'number_of_bed' => 1,
        'price' => 150000,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('rooms')->insert([
      'room_number' => '128',
      'room_type_id' => 5,
      'bed_type' => 'Double',
      'number_of_bed' => 1,
      'price' => 150000,
      'created_at' => now(),
      'updated_at' => now(),
  ]);
    }
}
