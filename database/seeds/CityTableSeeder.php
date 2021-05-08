<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataCity = array();
        $json = File::get(public_path("/data/city.json"));
        $data = json_decode($json);
        foreach ($data as $row) {
            $dataCity = array(
                'province_id' => $row->province_id,
                'country_id' => $row->country_id,
                'code' => $row->code,
                'area_code' => $row->area_code,
                'name' => trim($row->name),
                'is_posted' => $row->is_posted,
                'created_at' => date('Y-m-d H:i:s'),
            );
            DB::table('city')->insert($dataCity);
        
        }
    }
}
