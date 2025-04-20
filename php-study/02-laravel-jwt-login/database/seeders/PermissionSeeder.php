<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $employee = Role::create(['name' => 'employee']);
        $user = Role::create(['name' => 'user']);

        $viewPermissions = Permission::create(['name' => 'view-permission']);
        $createPermission = Permission::create(['name' => 'create-permission']);
        $editPermission = Permission::create(['name' => 'edit-permission']);
        $deletePermission = Permission::create(['name' => 'delete-permission']);

        $viewRoles = Permission::create(['name' => 'view-role']);
        $createRole = Permission::create(['name' => 'create-role']);
        $editRole = Permission::create(['name' => 'edit-role']);
        $deleteRole = Permission::create(['name' => 'delete-role']);

        $viewUsers = Permission::create(['name' => 'view-user']);
        $createUser = Permission::create(['name' => 'create-user']);
        $editUser = Permission::create(['name' => 'edit-user']);
        $deleteUser = Permission::create(['name' => 'delete-user']);

        $manageRooms = Permission::create(['name' => 'manage-rooms']);
        $viewRooms = Permission::create(['name' => 'view-room']);
        $createRoom = Permission::create(['name' => 'create-room']);
        $editRoom = Permission::create(['name' => 'edit-room']);
        $deleteRoom = Permission::create(['name' => 'delete-room']);
        
        $admin->givePermissionTo([
            $viewPermissions, $createPermission, $editPermission, $editPermission,
            $viewRoles, $createRole, $editRole, $deleteRole,
            $viewUsers, $createUser, $editUser, $deleteUser,
            $viewRooms, $createRoom, $editRoom, $deleteRoom
        ]);
        $manager->givePermissionTo([
            $viewUsers, $createUser, $editUser, $deleteUser,
            $viewRooms, $createRoom, $editRoom, $deleteRoom,
            $viewRoles, $viewPermissions,
        ]);
        $employee->givePermissionTo([$viewUsers, $viewRooms, $viewRoles,  $viewPermissions]);

        $user1 = User::find(1);
        $user1->assignRole($admin);
        
        $user2 = User::find(2);
        $user2->assignRole($manager);
        // Gán permission trực tiếp (tùy chọn)
        $user2->givePermissionTo([$createRole, $editRole]);

        $user3 = User::find(3);
        $user3->assignRole($admin);

        $user4 = User::find(4);
        $user4->assignRole($employee);        

        $user5 = User::find(5);
        $user5->assignRole($user);
        
    }
}