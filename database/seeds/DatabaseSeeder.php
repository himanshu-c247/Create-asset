<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     *
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            TeamsTableSeeder::class,
            SegmentSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            AssetsTableSeeder::class,
            CategorySeeder::class,
        ]);

    }
}
