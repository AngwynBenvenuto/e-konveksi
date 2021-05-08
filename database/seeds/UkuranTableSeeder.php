<?php

use Illuminate\Database\Seeder;

class UkuranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ukuran')->insert([
            array(
                'name' => 'S',
                'description' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'M',
                'description' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'L',
                'description' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'XL',
                'description' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            )
        ]);
    }
}
