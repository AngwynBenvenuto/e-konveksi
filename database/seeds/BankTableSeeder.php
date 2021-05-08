<?php

use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataBank = array();
        $json = File::get(public_path("/data/bank.json"));
        $data = json_decode($json);
        foreach ($data as $row) {
            $dataBank[] = array(
                'name' => $row->name,
                'description' => $row->description,
                'created_at' => date('Y-m-d H:i:s'),
            );
        }
        DB::table('bank')->insert($dataBank);
    }
}
