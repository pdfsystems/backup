<?php

use App\Models\Application;
use Symfony\Component\HttpFoundation\Response;

test('create applications', function () {
    $response = $this->withToken($this->token)->withHeader('Accept', 'application/json')->post('/api/applications', [
        'name' => 'Test Application',
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
    expect($response->json('name'))->toBe('Test Application')
        ->and($response->json('id'))->toBeGreaterThan(0);
});

test('list applications', function () {
    Application::factory()->count(10)->create();
    $response = $this->withToken($this->token)->withHeader('Accept', 'application/json')->get('/api/applications');

    $response->assertStatus(Response::HTTP_OK);
    expect($response->json('total'))->toBe(10)
        ->and($response->json('data'))->toHaveCount(10);
});

test('show application', function () {
    $application = Application::factory()->create();
    $response = $this->withToken($this->token)->withHeader('Accept', 'application/json')->get("/api/applications/{$application->getKey()}");

    $response->assertStatus(Response::HTTP_OK);
    expect($response->json('id'))->toBe($application->getKey())
        ->and($response->json('name'))->toBe($application->name);
});

test('update application', function () {
    $application = Application::factory()->create();
    $response = $this->withToken($this->token)->withHeader('Accept', 'application/json')->put("/api/applications/{$application->getKey()}", [
        'name' => 'Updated Application',
    ]);

    $response->assertStatus(Response::HTTP_OK);
    expect($response->json('id'))->toBe($application->getKey())
        ->and($response->json('name'))->toBe('Updated Application')
        ->and($application->refresh()->name)->toBe('Updated Application');
});

test('remove application', function () {
    $application = Application::factory()->create();
    $response = $this->withToken($this->token)->withHeader('Accept', 'application/json')->delete("/api/applications/{$application->getKey()}");

    $response->assertStatus(Response::HTTP_NO_CONTENT);
    expect($response->isEmpty())->toBeTrue()
        ->and(Application::count())->toBe(0);
});
