<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateSuperAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            'role' => 'super_admin',
            'email' => 'admin@myemail.com',
            'email_verified_at' => now(),
            'password' => 'superadmin',
        ];

        $profileData = [
            'content' => [
                'first_name' => 'Super',
                'last_name' => 'Admin',
            ],
        ];

        $user = User::create($userData);
        $user
            ->profile()
            ->create($profileData);
    }
}
