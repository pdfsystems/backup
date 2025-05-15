<?php

use App\Models\Application;
use App\Models\Backup;
use Symfony\Component\HttpFoundation\Response;

test('create applications', function () {
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->post('/api/applications', [
        'name' => 'Test Application',
    ]);

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('list applications', function () {
    Application::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->get('/api/applications');

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('show application', function () {
    $application = Application::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->get("/api/applications/{$application->getKey()}");

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('update application', function () {
    $application = Application::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->put("/api/applications/{$application->getKey()}", [
        'name' => 'Updated Application',
    ]);

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('remove application', function () {
    $application = Application::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->delete("/api/applications/{$application->getKey()}");

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('create backups', function () {
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->post('/api/backups', [
        'name' => 'Test Backup',
    ]);

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('list backups', function () {
    Backup::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->get('/api/backups');

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('show backup', function () {
    $backup = Backup::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->get("/api/backups/{$backup->getKey()}");

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('update backup', function () {
    $backup = Backup::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->put("/api/backups/{$backup->getKey()}", [
        'name' => 'Updated Backup',
    ]);

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

test('remove backup', function () {
    $backup = Backup::factory()->create();
    $response = $this->withToken($this->noAccessToken)->withHeader('Accept', 'application/json')->delete("/api/backups/{$backup->getKey()}");

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});
