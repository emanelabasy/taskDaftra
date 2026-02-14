<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'access-all',
                'display_name' => 'all access',
                'description' => 'all access',
            ],
            [
                'name' => 'warehouse-type-all',
                'display_name' => 'All warehouse type',
                'description' => 'All warehouse type',
            ],
            [
                'name' => 'statistics',
                'display_name' => 'Statistics',
                'description' => 'Statistics',
            ],
            [
                'name' => 'admin-panel',
                'display_name' => 'login to admin panel',
                'description' => 'login to admin panel',
            ],
            [
                'name' => 'warehouse-all',
                'display_name' => 'All warehouse',
                'description' => 'All warehouse',
            ],
            [
                'name' => 'warehouse-list',
                'display_name' => 'Display warehouse Listing',
                'description' => 'See only Listing Of warehouse',
            ],
            [
                'name' => 'warehouse-create',
                'display_name' => 'Create warehouse',
                'description' => 'Create New warehouse',
            ],
            [
                'name' => 'warehouse-edit',
                'display_name' => 'Edit warehouse',
                'description' => 'Edit warehouse',
            ],
            [
                'name' => 'warehouse-show',
                'display_name' => 'Show warehouse',
                'description' => 'Show warehouse',
            ],
            [
                'name' => 'warehouse-delete',
                'display_name' => 'Delete warehouse',
                'description' => 'Delete warehouse',
            ],
            [
                'name' => 'user-all',
                'display_name' => 'All User',
                'description' => 'All User',
            ],
            [
                'name' => 'user-list',
                'display_name' => 'Display User',
                'description' => 'Display User',
            ],
            [
                'name' => 'user-delete',
                'display_name' => 'Delete User',
                'description' => 'Delete User',
            ],
            [
                'name' => 'user-show',
                'display_name' => 'Show User',
                'description' => 'Show User',
            ],
            [
                'name' => 'user-edit',
                'display_name' => 'Edit User',
                'description' => 'Edit User',
            ],
            [
                'name' => 'user-profile',
                'display_name' => 'User Has Profile',
                'description' => 'User Has Profile',
            ],
            [
                'name' => 'inventory-all',
                'display_name' => 'All inventory',
                'description' => 'All inventory',
            ],
            [
                'name' => 'inventory-list',
                'display_name' => 'Display inventory Listing',
                'description' => 'See only inventory Of warehouse',
            ],
            [
                'name' => 'inventory-create',
                'display_name' => 'Create inventory',
                'description' => 'Create New inventory',
            ],
            [
                'name' => 'inventory-edit',
                'display_name' => 'Edit inventory',
                'description' => 'Edit inventory',
            ],
            [
                'name' => 'inventory-delete',
                'display_name' => 'Delete inventory',
                'description' => 'Delete inventory',
            ],

            [
                'name' => 'stock-all',
                'display_name' => 'All stock',
                'description' => 'All stock',
            ],
            [
                'name' => 'stock-list',
                'display_name' => 'Display stock Listing',
                'description' => 'See only stock Of warehouse',
            ],
            [
                'name' => 'stock-create',
                'display_name' => 'Create stock',
                'description' => 'Create New stock',
            ],
            [
                'name' => 'stock-edit',
                'display_name' => 'Edit stock',
                'description' => 'Edit stock',
            ],
            [
                'name' => 'stock-delete',
                'display_name' => 'Delete stock',
                'description' => 'Delete stock',
            ],
            [
                'name' => 'stockTransfer-all',
                'display_name' => 'All stockTransfer',
                'description' => 'All stockTransfer',
            ],
            [
                'name' => 'stockTransfer-list',
                'display_name' => 'Display stockTransfer Listing',
                'description' => 'See only stockTransfer Of warehouse',
            ],
            [
                'name' => 'stockTransfer-create',
                'display_name' => 'Create stockTransfer',
                'description' => 'Create New stockTransfer',
            ],
            [
                'name' => 'stockTransfer-edit',
                'display_name' => 'Edit stockTransfer',
                'description' => 'Edit stockTransfer',
            ],
            [
                'name' => 'stockTransfer-delete',
                'display_name' => 'Delete stockTransfer',
                'description' => 'Delete stockTransfer',
            ]  
            
        ];

        Permission::upsert($permissions, ['id', 'name']);

        // Permission::insert($permissions);
    }
}