<?php

namespace Database\Seeders;

use App\Models\CustomPackage;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceProviders = User::role('service provider')->where('status', 'approved')->get();
        $clients = User::role('user')->where('status', 'approved')->get();

        foreach ($serviceProviders as $provider) {
            // Create 1-3 custom packages per service provider
            $packageCount = rand(1, 3);

            for ($i = 0; $i < $packageCount; $i++) {
                $client = $clients->random();

                CustomPackage::create([
                    'user_id' => $client->id,
                    'service_provider_id' => $provider->id,
                    'name' => $this->getCustomPackageName($i),
                    'description' => $this->getCustomPackageDescription($i),
                    'features' => json_encode($this->getCustomPackageFeatures($i)),
                    'price' => rand(300, 4000),
                    'payment_status' => $this->getRandomPaymentStatus(),
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }

    private function getCustomPackageName($index)
    {
        $names = [
            'Custom Website Development',
            'Professional Photography Session',
            'Event Planning Services',
            'Graphic Design Package',
            'Video Production Project',
            'Interior Design Consultation',
            'Marketing Campaign Design',
            'Logo and Branding Package',
            'Social Media Management',
            'Content Creation Services',
            'Business Consulting Package',
            'Fitness Training Program',
            'Tutoring Services Package',
            'Translation Services',
            'Cleaning Service Package'
        ];

        return $names[$index] ?? 'Custom Package ' . ($index + 1);
    }

    private function getCustomPackageDescription($index)
    {
        $descriptions = [
            'Looking for a professional to develop a custom website for my business. Need a modern, responsive design with e-commerce functionality.',
            'Need professional photography services for a family event. Looking for someone with experience in event photography.',
            'Planning a corporate event and need professional event planning services. Event will have 100+ attendees.',
            'Need graphic design services for marketing materials including brochures, business cards, and social media graphics.',
            'Looking for video production services for a product launch. Need high-quality video with professional editing.',
            'Seeking interior design consultation for a home renovation project. Need help with color schemes and furniture selection.',
            'Need a comprehensive marketing campaign design including digital and print materials.',
            'Looking for logo design and complete branding package for a new business venture.',
            'Need social media management services for multiple platforms. Looking for someone to handle content creation and engagement.',
            'Require content creation services for blog posts, articles, and social media content.',
            'Seeking business consulting services to help improve operations and increase profitability.',
            'Looking for personal fitness training program tailored to specific goals and schedule.',
            'Need tutoring services for high school subjects. Looking for experienced educators.',
            'Require professional translation services for business documents and website content.',
            'Need regular cleaning services for office space. Looking for reliable and professional service.'
        ];

        return $descriptions[$index] ?? 'Custom package description for specialized services.';
    }

    private function getCustomPackageFeatures($index)
    {
        $features = [
            ['Responsive Design', 'SEO Optimization', 'Admin Panel', 'E-commerce Integration'],
            ['Event Photography', 'Portrait Sessions', 'Photo Editing', 'Digital Delivery'],
            ['Venue Selection', 'Catering Coordination', 'Event Timeline', 'Day-of Coordination'],
            ['Logo Design', 'Brand Guidelines', 'Marketing Materials', 'Social Media Graphics'],
            ['Video Production', 'Professional Editing', 'Motion Graphics', 'Final Delivery'],
            ['Color Consultation', 'Furniture Selection', 'Space Planning', 'Design Boards'],
            ['Campaign Strategy', 'Digital Marketing', 'Print Materials', 'Analytics'],
            ['Logo Design', 'Brand Identity', 'Style Guide', 'Marketing Collateral'],
            ['Content Creation', 'Social Media Management', 'Engagement Strategy', 'Monthly Reports'],
            ['Blog Writing', 'Article Creation', 'SEO Content', 'Social Media Posts'],
            ['Business Analysis', 'Strategy Development', 'Performance Review', 'Implementation Plan'],
            ['Personal Training', 'Nutrition Guidance', 'Progress Tracking', 'Workout Plans'],
            ['Subject Tutoring', 'Test Preparation', 'Homework Help', 'Progress Reports'],
            ['Document Translation', 'Website Localization', 'Certified Translation', 'Quick Turnaround'],
            ['Regular Cleaning', 'Deep Cleaning', 'Quality Guarantee', 'Flexible Scheduling']
        ];

        return $features[$index] ?? ['Professional Service', 'Quality Guarantee', 'Timely Delivery'];
    }

    private function getRandomPaymentStatus()
    {
        $statuses = ['pending', 'paid', 'failed', 'refunded'];
        $weights = [60, 30, 8, 2]; // 60% pending, 30% paid, 8% failed, 2% refunded

        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $statuses[$index];
            }
        }

        return 'pending';
    }
}
