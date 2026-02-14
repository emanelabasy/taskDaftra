<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $user = User::factory()->create([
            'name'        => 'Test User',
            'email'       => 'test@example.com',
            'password'    => Hash::make('12345678')
        ]);
        $role = Role::first();
        $user->roles()->sync($role);
    }
}
