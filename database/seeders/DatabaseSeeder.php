<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Support\Facades\Date;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // =================
        // MENUS
        // =================
        $menus = [
            [
                'name' => 'dashboard',
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'order' => 1,
                'permission_name' => 'view dashboard menu',
            ],
            [
                'name' => 'system-settings',
                'label' => 'User Management',
                'icon' => 'fas fa-users-cog',
                'order' => 2,
                'permission_name' => 'view system-settings menu',
                'children' => [
                    [
                        'name' => 'users',
                        'label' => 'Users',
                        'route' => 'system-settings.users.index',
                        'icon' => 'far fa-circle',
                        'order' => 1,
                        'permission_name' => 'view users menu',
                    ],
                    [
                        'name' => 'roles',
                        'label' => 'Roles',
                        'route' => 'system-settings.roles.index',
                        'icon' => 'far fa-circle',
                        'order' => 2,
                        'permission_name' => 'view roles menu',
                    ],
                    [
                        'name' => 'permissions',
                        'label' => 'Permissions',
                        'route' => 'system-settings.permissions.index',
                        'icon' => 'far fa-circle',
                        'order' => 3,
                        'permission_name' => 'view permissions menu',
                    ],
                    [
                        'name' => 'menu-management',
                        'label' => 'Menu Management',
                        'route' => 'system-settings.menus.index',
                        'icon' => 'far fa-circle',
                        'order' => 4,
                        'permission_name' => 'view menu-management menu',
                    ],
                ]
            ],
        ];

        foreach ($menus as $m) {
            $children = $m['children'] ?? null;
            unset($m['children']);

            $parent = Menu::create(array_merge($m, ['is_active' => true]));

            if ($children) {
                foreach ($children as $c) {
                    Menu::create(array_merge($c, [
                        'parent_id' => $parent->id,
                        'is_active' => true
                    ]));
                }
            }
        }

        // =================
        // Roles
        // =================
        $roles = [
            // superadmin
            ['name' => 'superadmin', 'guard_name' => 'web'],
        ];

        foreach ($roles as $itemData) {
            Role::create($itemData);
        }

        // =================
        // PERMISSIONS
        // =================
        $permissions = [
            // Menu
            ['name' => 'view dashboard menu', 'guard_name' => 'web'],
            ['name' => 'view system-settings menu', 'guard_name' => 'web'],
            ['name' => 'view users menu', 'guard_name' => 'web'],
            ['name' => 'view roles menu', 'guard_name' => 'web'],
            ['name' => 'view permissions menu', 'guard_name' => 'web'],
            ['name' => 'view menu-management menu', 'guard_name' => 'web'],

            // Profile
            ['name' => 'read profile', 'guard_name' => 'web'],
            ['name' => 'update profile', 'guard_name' => 'web'],
            ['name' => 'delete profile', 'guard_name' => 'web'],

            // User
            ['name' => 'create users', 'guard_name' => 'web'],
            ['name' => 'read users', 'guard_name' => 'web'],
            ['name' => 'update users', 'guard_name' => 'web'],
            ['name' => 'delete users', 'guard_name' => 'web'],

            // Role
            ['name' => 'create roles', 'guard_name' => 'web'],
            ['name' => 'read roles', 'guard_name' => 'web'],
            ['name' => 'update roles', 'guard_name' => 'web'],
            ['name' => 'delete roles', 'guard_name' => 'web'],

            // Permission
            ['name' => 'create permissions', 'guard_name' => 'web'],
            ['name' => 'read permissions', 'guard_name' => 'web'],
            ['name' => 'update permissions', 'guard_name' => 'web'],
            ['name' => 'delete permissions', 'guard_name' => 'web'],

            // Menu Management
            ['name' => 'create menu-management', 'guard_name' => 'web'],
            ['name' => 'read menu-management', 'guard_name' => 'web'],
            ['name' => 'update menu-management', 'guard_name' => 'web'],
            ['name' => 'delete menu-management', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $itemData) {
            Permission::create($itemData);
        }

        // =================
        // USERS
        // =================
        $user = User::create([
            'name' => 'Admin Tampan',
            'email' => 'admin@mail.com',
            'email_verified_at' => Date::now(),
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('superadmin');
    }
}
