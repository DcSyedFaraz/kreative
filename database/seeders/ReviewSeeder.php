<?php

namespace Database\Seeders;

use App\Models\CustomerReview;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceProviders = User::role('service provider')->where('status', 'approved')->get();
        $clients = User::role('user')->where('status', 'approved')->get();

        // Create customer reviews (reviews given by clients to service providers)
        foreach ($serviceProviders as $provider) {
            // Create 3-8 reviews per service provider
            $reviewCount = rand(3, 8);
            $selectedClients = $clients->random(min($reviewCount, $clients->count()));

            foreach ($selectedClients as $client) {
                CustomerReview::create([
                    'customer_id' => $client->id,
                    'provider_id' => $provider->id,
                    'rating' => rand(3, 5), // Mostly positive ratings
                    'content' => $this->getRandomReviewComment(),
                    'created_at' => now()->subDays(rand(1, 90)),
                ]);
            }
        }

        // Create regular reviews (general reviews)
        $users = User::where('status', 'approved')->get();

        foreach ($users as $user) {
            // Create 1-3 reviews per user
            $reviewCount = rand(1, 3);

            for ($i = 0; $i < $reviewCount; $i++) {
                // For regular reviews, we need a customer_id (another user)
                $otherUsers = $users->where('id', '!=', $user->id);
                if ($otherUsers->count() > 0) {
                    $customer = $otherUsers->random();

                    Review::create([
                        'user_id' => $user->id,
                        'customer_id' => $customer->id,
                        'content' => $this->getRandomReviewContent(),
                        'rating' => rand(3, 5),
                        'created_at' => now()->subDays(rand(1, 60)),
                    ]);
                }
            }
        }
    }

    private function getRandomReviewComment()
    {
        $comments = [
            'Excellent service! Very professional and delivered exactly what I needed.',
            'Great communication throughout the project. Highly recommended!',
            'Quality work and attention to detail. Will definitely work with again.',
            'Very responsive and completed the project on time. Great experience!',
            'Professional, reliable, and exceeded my expectations. Thank you!',
            'Outstanding work quality and customer service. Highly satisfied!',
            'Very knowledgeable and helpful. The final result was perfect.',
            'Great value for money. Professional service and excellent results.',
            'Prompt delivery and high-quality work. Very happy with the service.',
            'Excellent communication and delivered beyond expectations.',
            'Professional approach and great attention to detail. Recommended!',
            'Very satisfied with the work. Professional and reliable service.',
            'Great experience working together. Quality work and good communication.',
            'Excellent service provider. Delivered exactly what was promised.',
            'Very professional and easy to work with. Great results!',
            'Outstanding quality and service. Will definitely recommend to others.',
            'Great work ethic and professional attitude. Highly satisfied!',
            'Excellent communication and delivered on time. Great experience!',
            'Very reliable and professional. Quality work at a fair price.',
            'Great service and attention to detail. Highly recommended!'
        ];

        return $comments[array_rand($comments)];
    }

    private function getRandomReviewContent()
    {
        $contents = [
            'I had an excellent experience working with this service provider. The communication was clear throughout the entire process, and they delivered exactly what I was looking for. The quality of work exceeded my expectations, and I would definitely recommend them to others. Professional, reliable, and great value for money.',

            'This service provider is truly outstanding. They were very responsive to all my questions and concerns, and the final result was exactly what I needed. The attention to detail was impressive, and they completed the project on time. I\'m very satisfied and would work with them again.',

            'Great experience from start to finish. The service provider was professional, knowledgeable, and easy to work with. They understood my requirements perfectly and delivered high-quality results. The communication was excellent, and I felt confident throughout the entire process.',

            'I\'m very happy with the service I received. The provider was professional, reliable, and delivered exactly what was promised. The quality of work was excellent, and they were very responsive to any changes I requested. Highly recommended for anyone looking for quality service.',

            'Outstanding service and results! The provider was very professional and took the time to understand my specific needs. The final deliverable exceeded my expectations, and the communication throughout the project was excellent. I would definitely work with them again.',

            'Excellent experience working with this service provider. They were very professional, delivered on time, and the quality of work was outstanding. The communication was clear and consistent, and they were very responsive to any questions I had. Highly recommended!',

            'Great service and professional approach. The provider was very knowledgeable and delivered exactly what I needed. The attention to detail was impressive, and they completed the project within the agreed timeline. I\'m very satisfied with the results.',

            'Professional, reliable, and excellent quality work. The service provider was very easy to work with and delivered outstanding results. The communication was great throughout the project, and they were very responsive to any requests. Highly recommended!',

            'I had a wonderful experience working with this service provider. They were professional, delivered high-quality work, and exceeded my expectations. The communication was excellent, and they were very responsive to any changes I requested. Great value for money.',

            'Outstanding service provider with excellent results. They were very professional, delivered on time, and the quality of work was exceptional. The communication was clear and consistent, and they were very responsive to any questions. Highly satisfied!'
        ];

        return $contents[array_rand($contents)];
    }
}
