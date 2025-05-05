<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'username'   => 'jdoe',
                'email'      => 'jdoe@example.com',
                'name'       => 'John',
                'last_name'  => 'Doe',
                'birth_date' => '1990-05-15',
                'rol_id'     => 1,
                'enabled'    => true,
            ],
            [
                'username'   => 'asmith',
                'email'      => 'asmith@example.com',
                'name'       => 'Anna',
                'last_name'  => 'Smith',
                'birth_date' => '1988-10-25',
                'rol_id'     => 2,
                'enabled'    => true,
            ],
            [
                'username'   => 'bwilliams',
                'email'      => 'b.williams@example.com',
                'name'       => 'Brian',
                'last_name'  => 'Williams',
                'birth_date' => '1985-07-12',
                'rol_id'     => 3,
                'enabled'    => true,
            ],
            [
                'username'   => 'klopez',
                'email'      => 'klopez@example.com',
                'name'       => 'Karen',
                'last_name'  => 'Lopez',
                'birth_date' => '1993-03-22',
                'rol_id'     => 3,
                'enabled'    => true,
            ],
            [
                'username'   => 'mgomez',
                'email'      => 'mgomez@example.com',
                'name'       => 'Miguel',
                'last_name'  => 'Gómez',
                'birth_date' => '1996-11-01',
                'rol_id'     => 2,
                'enabled'    => true,
            ],
        ]);
    }
}
