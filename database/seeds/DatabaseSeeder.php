<?php

use App\Models\User;
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
        $users = array(
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@test.com',
                'password' => bcrypt('123456'),
                'role' => 'superadmin'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('123456'),
                'role' => 'admin'
            ],
            [
                'name' => 'User',
                'email' => 'user@test.com',
                'password' => bcrypt('123456'),
                'role' => 'user'
            ],
            [
                'name' => 'Mr. John',
                'email' => 'shr@test.com',
                'password' => bcrypt('123456'),
                'role' => 'shr'
            ],
            [
                'name' => 'Mrs. Lee',
                'email' => 'hr@test.com',
                'password' => bcrypt('123456'),
                'role' => 'hr'
            ],
        );

        foreach ($users as $value) {
            $user = new User();
            $user->fill($value);
            $user->save();
        }
    }
}
