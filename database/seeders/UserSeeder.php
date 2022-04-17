<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userFactory = new UserFactory();
        $user = $userFactory->definition();
        $user['email'] = 'administrator@mail.com';
        $user['role'] = UserRoleEnum::ADMINISTRATOR;
        User::create($user);
        $user = $userFactory->definition();
        $user['email'] = 'secretary@mail.com';
        $user['role'] = UserRoleEnum::SECRETARY;
        User::create($user);
    }
}
