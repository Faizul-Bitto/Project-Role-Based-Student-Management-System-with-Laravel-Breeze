<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Check if the Admin role exists
        $adminRole = Role::where( 'name', 'Admin' )->first();

        if ( !$adminRole ) {
            $this->command->error( 'Admin role does not exist. Please run the RoleSeeder first.' );
            return;
        }

        // Create a default admin user
        $adminUser = User::firstOrCreate( [
            'name'     => 'Admin',
            'email'    => 'admin@startsmartz.com',
            'phone'    => '1234567890',
            'role'     => 'Admin',
            'password' => Hash::make( '1234' ), // Set a default password for the admin user
        ] );

        // Assign the 'Admin' role to the user
        $adminUser->assignRole( 'Admin' );

        $this->command->info( 'Default Admin user created successfully.' );
    }

}
