<?php

use Illuminate\Database\Seeder;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
          'email' => 'admin@admin.com',
          'first_name' => 'admin',
          'password' => bcrypt('admin'),
          'college' => 'admin',
          'department' => 'department',
     ]);
    }
}
