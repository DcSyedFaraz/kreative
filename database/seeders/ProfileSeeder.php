<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Skip if user already has a profile
            if ($user->profile) {
                continue;
            }

            $profileData = [
                'user_id' => $user->id,
                'display_name' => $user->fname . ' ' . $user->lname,
                'email' => $user->email,
                'phone_number' => $this->generatePhoneNumber(),
                'address' => $this->getRandomAddress(),
                'service_area' => $this->getServiceArea($user),
                'shop_address' => $user->hasRole('service provider') ? $this->getRandomAddress() : null,
            ];

            Profile::create($profileData);
        }
    }

    private function generatePhoneNumber()
    {
        return '+1-' . rand(200, 999) . '-' . rand(200, 999) . '-' . rand(1000, 9999);
    }

    private function getRandomAddress()
    {
        $addresses = [
            '123 Main Street',
            '456 Oak Avenue',
            '789 Pine Road',
            '321 Elm Street',
            '654 Maple Drive',
            '987 Cedar Lane',
            '147 Birch Boulevard',
            '258 Willow Way',
            '369 Spruce Street',
            '741 Cherry Avenue'
        ];

        return $addresses[array_rand($addresses)];
    }

    private function getServiceArea($user)
    {
        if (!$user->hasRole('service provider')) {
            return null;
        }

        $cities = [
            'New York, NY',
            'Los Angeles, CA',
            'Chicago, IL',
            'Houston, TX',
            'Phoenix, AZ',
            'Philadelphia, PA',
            'San Antonio, TX',
            'San Diego, CA',
            'Dallas, TX',
            'San Jose, CA'
        ];

        $selectedCities = array_rand($cities, rand(1, 3));
        if (!is_array($selectedCities)) {
            $selectedCities = [$selectedCities];
        }

        $serviceAreas = [];
        foreach ($selectedCities as $index) {
            $serviceAreas[] = $cities[$index];
        }

        return implode(', ', $serviceAreas);
    }
}
