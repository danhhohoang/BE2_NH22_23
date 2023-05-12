<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Adminstrator',
            'email'=>'nhincc@gmail.com',
            'email_verified_at'=>'2022-05-24 06:03:35',
            'password'=>'12345678',
            'role'=>1,
            'phone'=>'0795426106',
            'created_at'=>'2022-05-24 06:03:20',
            'updated_at'=>'2022-05-24 06:03:35',
        ]);
    }
}
