<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create( [
         'name'=>'user-list',
         'guard_name'=>'web',
         'display_name'=>'List',
         'type'=>'User',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
         ] );

         Permission::create( [
         'name'=>'user-create',
         'guard_name'=>'web',
         'display_name'=>'Create',
         'type'=>'User',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
         ] );

         Permission::create( [
         'name'=>'user-edit',
         'guard_name'=>'web',
         'display_name'=>'Edit',
         'type'=>'User',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
         ] );

         Permission::create( [
         'name'=>'user-delete',
         'guard_name'=>'web',
         'display_name'=>'Delete',
         'type'=>'User',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
         ] );


         Permission::create( [
         'name'=>'role-list',
         'guard_name'=>'web',
         'display_name'=>'List',
         'type'=>'Role',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
         ] );

         Permission::create( [
         'name'=>'role-create',
         'guard_name'=>'web',
         'display_name'=>'Create',
         'type'=>'Role',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
          ] );
         Permission::create( [
         'name'=>'role-edit',
         'guard_name'=>'web',
         'display_name'=>'Edit',
         'type'=>'Role',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
         ] );
         Permission::create( [
         'name'=>'role-delete',
         'guard_name'=>'web',
         'display_name'=>'Delete',
         'type'=>'Role',
         'created_at'=>'2020-07-09 08:22:42',
         'updated_at'=>'2020-07-09 08:22:42'
         ] );

         $role = Role::create(['name' => 'admin', 'slug' => 'admin','display_name' =>'Admin']);
         $role->givePermissionTo(Permission::all());
         $role1 = Role::create(['name' => 'user', 'slug' => 'user','display_name' =>'User']);
         $role2 = Role::create(['name' => 'service_provider', 'slug' => 'service-provider','display_name' =>'Service Provider']);

         $user = \App\Models\User::create([
            'name' => 'Admin',
             'email' => 'admin@gmail.com',
             'email_verified_at' => '2019-11-30 18:24:06',
             'password' => bcrypt('12345'),

             'remember_token' => NULL,
             'status' => 1,
             'type' => 'admin',
             'profile' => 'default.png',
             'created_at' => NULL,
             'updated_at' => '2019-11-30 18:24:06',
         ]);

         $user->assignRole($role->name);

         $user = \App\Models\User::create([
            'name' => 'User',
             'email' => 'user@gmail.com',
             'email_verified_at' => '2019-11-30 18:24:06',
             'password' => bcrypt('12345'),

             'remember_token' => NULL,
             'status' => 1,
             'type' => 'admin',
             'profile' => 'default.png',
             'created_at' => NULL,
             'updated_at' => '2019-11-30 18:24:06',
         ]);
         $user->assignRole($role1->name);

         $user = \App\Models\User::create([
            'name' => 'Service Provider',
             'email' => 'serviceprovider@gmail.com',
             'email_verified_at' => '2019-11-30 18:24:06',
             'password' => bcrypt('12345'),

             'remember_token' => NULL,

             'status' => 1,
             'type' => 'admin',
             'profile' => 'default.png',
             'created_at' => NULL,
             'updated_at' => '2019-11-30 18:24:06',
         ]);
         $user->assignRole($role2->name);
    }
}
