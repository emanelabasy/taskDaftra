<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionsSeeder::class,
            UserSeeder::class,
            WarehouseSeeder::class,
            InventoryItemSeeder::class,
            StockSeeder::class,
            StockTransferSeeder::class,
        ]);

        ex:
        DB::table('permission_role')->insertOrIgnore([
            ['permission_id' => 1, 'role_id' => 1]
        ]);
    }
}
