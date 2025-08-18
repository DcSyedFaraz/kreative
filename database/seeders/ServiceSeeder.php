<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Photography',
                'description' => 'Professional photography services for events, portraits, and commercial needs'
            ],
            [
                'name' => 'Videography',
                'description' => 'High-quality video production for events, commercials, and documentaries'
            ],
            [
                'name' => 'Graphic Design',
                'description' => 'Creative graphic design services for logos, branding, and marketing materials'
            ],
            [
                'name' => 'Web Development',
                'description' => 'Custom website development and web application solutions'
            ],
            [
                'name' => 'Event Planning',
                'description' => 'Complete event planning and coordination services'
            ],
            [
                'name' => 'Catering',
                'description' => 'Professional catering services for events and special occasions'
            ],
            [
                'name' => 'Music & Entertainment',
                'description' => 'Live music, DJ services, and entertainment for events'
            ],
            [
                'name' => 'Interior Design',
                'description' => 'Interior design and decoration services for homes and businesses'
            ],
            [
                'name' => 'Fitness Training',
                'description' => 'Personal training and fitness coaching services'
            ],
            [
                'name' => 'Tutoring',
                'description' => 'Educational tutoring services for various subjects and levels'
            ],
            [
                'name' => 'Consulting',
                'description' => 'Business and professional consulting services'
            ],
            [
                'name' => 'Translation',
                'description' => 'Professional translation and interpretation services'
            ],
            [
                'name' => 'Cleaning Services',
                'description' => 'Residential and commercial cleaning services'
            ],
            [
                'name' => 'Pet Care',
                'description' => 'Pet sitting, walking, and grooming services'
            ],
            [
                'name' => 'Transportation',
                'description' => 'Transportation and delivery services'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
