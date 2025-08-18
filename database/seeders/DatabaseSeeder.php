<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles first
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'service provider']);

        // Create admin user
        $admin = User::factory()->create([
            'fname' => 'Test Admin',
            'lname' => 'Test Admin',
            'username' => 'Test Admin',
            'email' => 'admin@gmail.com',
            'status' => 'approved',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        // Create service provider
        $provider = User::factory()->create([
            'fname' => 'Test provider',
            'lname' => 'Test provider',
            'username' => 'Test provider',
            'email' => 'provider@gmail.com',
            'status' => 'approved',
            'password' => bcrypt('12345678'),
        ]);
        $provider->assignRole('service provider');

        // Create regular user
        $user = User::factory()->create([
            'fname' => 'Test user',
            'lname' => 'Test user',
            'username' => 'Test user',
            'email' => 'user@gmail.com',
            'status' => 'approved',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('user');

        // Create additional users
        User::factory(10)->create()->each(function ($user) {
            $roles = ['user', 'service provider'];
            $user->assignRole($roles[array_rand($roles)]);
        });

        // Call other seeders
        $this->call([
            PermissionsTableSeeder::class,
            ServiceSeeder::class,
            ProfileSeeder::class,
            PackageSeeder::class,
            ReviewSeeder::class,
            ChatSeeder::class,
            CustomPackageSeeder::class,
        ]);

        // Assign services to service providers
        $this->assignServicesToProviders();
    }

    private function assignServicesToProviders()
    {
        $serviceProviders = User::role('service provider')->get();
        $services = \App\Models\Service::all();

        foreach ($serviceProviders as $provider) {
            // Assign 2-4 random services to each provider
            $selectedServices = $services->random(rand(2, 4));

            foreach ($selectedServices as $service) {
                $provider->services()->attach($service->id, [
                    'display_on_profile' => rand(0, 1) === 1
                ]);
            }
        }
    }
}
