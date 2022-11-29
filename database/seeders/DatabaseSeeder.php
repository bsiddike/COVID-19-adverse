<?php

namespace Database\Seeders;

use Database\Seeders\Backend\AdminRegisterSeeder;
use Database\Seeders\Backend\SARegisterSeeder;
use Database\Seeders\Backend\Setting\PermissionSeeder;
use Database\Seeders\Backend\Setting\RolePermissionSeeder;
use Database\Seeders\Backend\Setting\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class, RoleSeeder::class, RolePermissionSeeder::class,
            SARegisterSeeder::class, AdminRegisterSeeder::class
        ]);

/*        $this->call([VaccineSeeder::class, SymptomSeeder::class, PatientSeeder::class]);*/
    }
}
