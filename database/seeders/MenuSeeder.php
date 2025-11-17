<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Dashboard
        Menu::create([
            'name' => 'dashboard',
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'order' => 1,
            'is_active' => true
        ]);

        // User Management (Parent)
        $userManagement = Menu::create([
            'name' => 'user-management',
            'label' => 'User Management',
            'icon' => 'fas fa-users-cog',
            'order' => 2,
            'is_active' => true
        ]);

        // Submenu User Management
        Menu::create([
            'name' => 'users',
            'label' => 'Users',
            'route' => 'user-management.users.index',
            'icon' => 'fas fa-user',
            'parent_id' => $userManagement->id,
            'order' => 1,
            'is_active' => true
        ]);

        Menu::create([
            'name' => 'roles',
            'label' => 'Roles',
            'route' => 'user-management.roles.index',
            'icon' => 'fas fa-user-shield',
            'parent_id' => $userManagement->id,
            'order' => 2,
            'is_active' => true
        ]);

        Menu::create([
            'name' => 'permissions',
            'label' => 'Permissions',
            'route' => 'user-management.permissions.index',
            'icon' => 'fas fa-key',
            'parent_id' => $userManagement->id,
            'order' => 3,
            'is_active' => true
        ]);

        Menu::create([
            'name' => 'menu-management',
            'label' => 'Menu Management',
            'route' => 'user-management.menus.index',
            'icon' => 'fas fa-bars',
            'parent_id' => $userManagement->id,
            'order' => 4,
            'is_active' => true
        ]);
    }
}
