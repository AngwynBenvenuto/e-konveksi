<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataUser = array();
        $json = File::get(public_path("/data/user.json"));
        $data = json_decode($json);
        foreach ($data as $row) {
            $dataUser[] = array(
                'role_id' => $row->role_id,
                'ikm_id' => null,
                'username' => $row->username,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'email' => $row->email,
                'password' => bcrypt('12345'),
                'is_base'=> $row->is_base,
                'created_at'=> date('Y-m-d H:i:s'),
            );
        }
        DB::table('users')->insert($dataUser);

    }
}
