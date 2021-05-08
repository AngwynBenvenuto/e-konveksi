<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataCountry = array();
        $json = File::get(public_path("/data/country.json"));
        $data = json_decode($json);
        foreach ($data as $row) {
            $dataCountry[] = array(
                'code' => $row->code,
                'name' => trim($row->name),
                'phone_code' => $row->phone_code,
                'created_at' => date('Y-m-d H:i:s'),
            );
        }
        DB::table('country')->insert($dataCountry);
    }
}
