<?php

use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataProvince = array();
        $json = File::get(public_path("/data/province.json"));
        $data = json_decode($json);
        foreach ($data as $row) {
            $dataProvince[] = array(
                'country_id' => $row->country_id,
                'zone_id' => $row->zone_id,
                'code' => $row->code,
                'name' => trim($row->name),
                'created_at' => date('Y-m-d H:i:s'),
            );
        }
        DB::table('province')->insert($dataProvince);
    }
}
