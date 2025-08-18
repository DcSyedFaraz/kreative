<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceProviders = User::role('service provider')->get();

        foreach ($serviceProviders as $provider) {
            // Create 2-4 packages per service provider
            $packageCount = rand(2, 4);

            for ($i = 0; $i < $packageCount; $i++) {
                $package = Package::create([
                    'user_id' => $provider->id,
                    'name' => $this->getPackageName($i),
                    'description' => $this->getPackageDescription($i),
                    'price' => $this->getPackagePrice($i),
                ]);

                // Create 3-6 items per package
                $itemCount = rand(3, 6);
                for ($j = 0; $j < $itemCount; $j++) {
                    PackageItem::create([
                        'package_id' => $package->id,
                        'features' => $this->getItemFeatures($j),
                    ]);
                }
            }
        }
    }

    private function getPackageName($index)
    {
        $names = [
            'Basic Package',
            'Standard Package',
            'Premium Package',
            'Deluxe Package',
            'Professional Package',
            'Ultimate Package',
            'Starter Package',
            'Complete Package',
            'Advanced Package',
            'Custom Package'
        ];

        return $names[$index] ?? 'Package ' . ($index + 1);
    }

    private function getPackageDescription($index)
    {
        $descriptions = [
            'Perfect for small projects and basic needs. Includes essential services to get you started.',
            'Our most popular package offering comprehensive services for medium-sized projects.',
            'Premium services with advanced features and priority support for demanding projects.',
            'Complete solution with all premium features, extended support, and customization options.',
            'Professional-grade services designed for businesses and large-scale projects.',
            'The ultimate package with everything included plus exclusive features and VIP support.',
            'Great starting point for new clients with essential services at an affordable price.',
            'Complete solution covering all aspects of your project from start to finish.',
            'Advanced features and tools for experienced users and complex requirements.',
            'Customized package tailored to your specific needs and requirements.'
        ];

        return $descriptions[$index] ?? 'A comprehensive package designed to meet your needs.';
    }

    private function getPackagePrice($index)
    {
        $prices = [99, 199, 299, 399, 499, 599, 79, 349, 449, 699];
        return $prices[$index] ?? rand(50, 800);
    }

    private function getItemFeatures($index)
    {
        $features = [
            'Initial consultation and project planning',
            'Design services with multiple revisions',
            'Development and implementation',
            'Quality assurance and testing',
            'Documentation and training',
            'Support and maintenance',
            'Custom features and integrations',
            'Performance optimization',
            'Security review and implementation',
            'Deployment and launch support',
            'Post-launch support and monitoring',
            'Analytics and reporting',
            'Content creation and management',
            'SEO optimization',
            'Mobile responsiveness'
        ];

        return $features[$index] ?? 'Professional service feature ' . ($index + 1);
    }
}
