<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);
        if (!$admin)
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'mobile' => '12345678',
                'password' => bcrypt('123456')
            ]);

        $admin->all_permissions = getAllPermissions()['all_permission'];
        $admin->current_permissions = getAllPermissions()['all_permission'];
        $admin->save();

    }
}
