<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'admin','display_name' => 'مدير المنصة','description' => ''],
            ['name' => 'manager','display_name' => 'مدير إداري','description' => ''],
            ['name' => 'storekeeper','display_name' => 'صاحب متجر ','description' => ''],
            ['name' => 'user','display_name' => 'مستخدم ','description' => ''],
        ];

        Role::upsert($roles, ['id', 'name']);

    }
}
