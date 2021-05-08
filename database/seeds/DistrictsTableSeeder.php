<?php

use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataDistricts = array();
        $json = File::get(public_path("/data/districts.json"));
        $data = json_decode($json);
        foreach ($data as $row) {
            $dataDistricts = array(
                'country_id' => $row->country_id,
                'province_id' => $row->province_id,
                'city_id' => $row->city_id,
                'code' => $row->code,
                'name' => trim($row->name),
                'created_at' => date('Y-m-d H:i:s'),
            );
            DB::table('districts')->insert($dataDistricts);
            
        }
        
    }
}
