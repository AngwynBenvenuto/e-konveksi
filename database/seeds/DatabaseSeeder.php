<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             //CountryTableSeeder::class,
             //ProvinceTableSeeder::class,
             //CityTableSeeder::class,
             //DistrictsTableSeeder::class,
             BankTableSeeder::class,
             UkuranTableSeeder::class,
             RoleTableSeeder::class,
             UserTableSeeder::class,
             PenjahitTableSeeder::class,
             JasaPengirimanTableSeeder::class
        ]);

    }
}
