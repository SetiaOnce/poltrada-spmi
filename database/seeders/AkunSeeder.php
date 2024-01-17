<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $user = [
                [
                   'name'=>'ADMINISTRATOR',
                   'email'=>'admin@gmail.com',
                    'role'=>'1',
                   'password'=> bcrypt('123456'),
                ],
                [
                   'name'=>'PENGELOLA',
                   'email'=>'pengelola@gmail.com',
                    'role'=>'2',
                   'password'=> bcrypt('123456'),
                ],
                [
                   'name'=>'PRODI',
                   'email'=>'prodi@gmail.com',
                    'role'=>'3',
                   'password'=> bcrypt('123456'),
                ],
                [
                   'name'=>'ASESOR',
                   'email'=>'asesor@gmail.com',
                    'role'=>'4',
                   'password'=> bcrypt('123456'),
                ],
            ];
    
            foreach ($user as $key => $value) {
                User::create($value);
            }
        }
    }
}
