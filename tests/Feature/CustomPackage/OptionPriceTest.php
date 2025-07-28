<?php

test('custom package price is calculated from options', function () {
    $provider = \App\Models\User::factory()->create();
    $user = \App\Models\User::factory()->create();

    \App\Models\PackageOption::create([
        'service_provider_id' => $provider->id,
        'name' => 'Photo',
        'base_price' => 2,
    ]);

    $response = $this->actingAs($user)->post(route('custom-packages.store', $provider), [
        'name' => 'My Package',
        'description' => 'desc',
        'features' => [],
        'options' => [1 => 3],
    ]);

    $package = \App\Models\CustomPackage::first();
    expect($package->price)->toBe(6.0);
});
