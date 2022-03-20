<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              =>  'Admin',
            'email'             =>  'admin@admin.com',
            'username'          =>  'adminUser',
            'role'              =>  'admin',
            'email_verified_at' =>  now(),
            'password'          =>  'admin_password',
            'remember_token'    =>  Str::random(10),
            'created_at'        =>  now(),
            'updated_at'        =>  now(),
        ]);

        User::factory()
            ->count(1000)
            ->has(Tweet::factory()->count(rand(5, 20)))
            ->create();
    }
}
