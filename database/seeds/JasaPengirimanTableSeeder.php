<?php

use Illuminate\Database\Seeder;

class JasaPengirimanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('delivery_services')->insert([
            array(
                'name' => 'jne',
                'description' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'tiki',
                'description' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'pos',
                'description' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
            )
        ]);
    }
}
