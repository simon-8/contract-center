<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(AdTableSeeder::class);
        $this->call(AdPlaceTableSeeder::class);
        $this->call(ManagerTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(GiftsTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategorysTableSeeder::class);
    }
}
