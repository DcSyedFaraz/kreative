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
        User::factory(10)->create();


        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'service provider']);


        $admin = User::factory()->create([
            'fname' => 'Test Admin',
            'lname' => 'Test Admin',
            'username' => 'Test Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');
        $provider = User::factory()->create([
            'fname' => 'Test provider',
            'lname' => 'Test provider',
            'username' => 'Test provider',
            'email' => 'provider@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $provider->assignRole('service provider');

        $this->call([PermissionsTableSeeder::class]);
    }
}
