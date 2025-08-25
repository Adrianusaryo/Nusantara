<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menu
        Permission::create(['name' => 'view_food']);
        Permission::create(['name' => 'add_food']);
        Permission::create(['name' => 'edit_food']);
        Permission::create(['name' => 'delete_food']);

        // Order
        Permission::create(['name' => 'view_order']);
        Permission::create(['name' => 'book_order']);
        Permission::create(['name' => 'set_status_checking']);
        Permission::create(['name' => 'set_status_delivering']);
        Permission::create(['name' => 'set_status_delivered']);
        Permission::create(['name' => 'order_report']);

        // User
        Permission::create(['name' => 'view_user']);
        Permission::create(['name' => 'add_user']);
        Permission::create(['name' => 'edit_user']);
        Permission::create(['name' => 'delete_user']);

        // Role
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Chef']);
        Role::create(['name' => 'Waitress']);
        Role::create(['name' => 'Driver']);
        Role::create(['name' => 'Customer']);

        // Role Assign
        $roleManager = Role::findByName('Manager');
        $roleManager->givePermissionTo('view_user');
        $roleManager->givePermissionTo('add_user');
        $roleManager->givePermissionTo('edit_user');
        $roleManager->givePermissionTo('delete_user');
        $roleManager->givePermissionTo('order_report');

        $roleWaitress = Role::findByName('Waitress');
        $roleWaitress->givePermissionTo('set_status_delivering');

        $roleChef = Role::findByName('Chef');
        $roleChef->givePermissionTo('view_food');
        $roleChef->givePermissionTo('add_food');
        $roleChef->givePermissionTo('edit_food');
        $roleChef->givePermissionTo('delete_food');
        $roleChef->givePermissionTo('set_status_checking');

        $roleDriver = Role::findByName('Driver');
        $roleDriver->givePermissionTo('set_status_delivered');

        $roleCustomer = Role::findByName('Customer');
        $roleCustomer->givePermissionTo('view_order');
        $roleCustomer->givePermissionTo('book_order');
    }
}
