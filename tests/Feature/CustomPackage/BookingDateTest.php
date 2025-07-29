<?php

use App\Models\User;
use App\Models\CustomPackage;

it('stores booking date on custom package creation', function () {
    $provider = User::factory()->create();
    $user = User::factory()->create();

    $date = now()->addDay()->toDateString();

    $this->actingAs($user)->post(route('custom-packages.store', $provider), [
        'name' => 'My Package',
        'description' => 'desc',
        'features' => [],
        'options' => [],
        'booking_date' => $date,
    ]);

    $package = CustomPackage::first();
    expect($package->booking_date->toDateString())->toBe($date);
});
