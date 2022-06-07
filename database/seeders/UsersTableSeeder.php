<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
//use App\Permission;
//use App\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $adminUser = User::create([
            'name'     => 'example',
            'email'    => 'example@ch.ru',
            'password' => bcrypt('password'),
        ]);

        $managerUser = User::create([
            'name'     => 'example',
            'email'    => 'example@ch.ru',
            'password' => bcrypt('password'),
        ]);


        $adminRole = Role::create([
            'name'  => 'admin'
        ]);

        $managerRole = Role::create([
            'name'  => 'manager'
        ]);


        $adminUser->assignRole($adminRole);
        $managerUser->assignRole($managerRole);
    }
}
