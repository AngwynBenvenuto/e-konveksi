<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataRole = array();
        $json = File::get(public_path("/data/role.json"));
        $data = json_decode($json);
        foreach ($data as $row) {
            $dataRole[] = array(
                'depth' => $row->depth,
                'lft' => $row->lft,
                'rgt' => $row->rgt,
                'name' => $row->name,
                'description' => $row->description,
                'is_base' => $row->is_base,
                'created_at'=> date('Y-m-d H:i:s'),
            );
        }
        DB::table('role')->insert($dataRole);
    }
}
