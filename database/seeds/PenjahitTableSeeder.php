<?php

use Illuminate\Database\Seeder;

class PenjahitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penjahit')->insert([
            array(
                'name'  => 'penjahit2',
                'code'  => \Lintas\helpers\utils::generatePenjahit(),
                'name_display' => 'penjahit2',
                'email' => 'penjahit2@gmail.com',
                'password' => bcrypt('12345'),
                'verified' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ),
        ]);

    }
}
