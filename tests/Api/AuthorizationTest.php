<?php

use App\Enums\Action;
use App\Models\Application;
use App\Models\Backup;
use Illuminate\Http\UploadedFile;
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

test('create backups with limited token', function () {
    $application = Application::factory()->create();
    $token = $this->parseToken(
        $this->admin->createToken('Create Backup Token', [
            Backup::class.':'.Action::Create->value,
        ])
    );

    $response = $this->withToken($token)->withHeader('Accept', 'application/json')->post('/api/backups', [
        'application_id' => $application->getKey(),
        'filename' => 'backup.zip',
        'mime_type' => 'application/zip',
        'size' => 654321,
        'meta' => json_encode([
            'key' => 'value',
        ]),
        'file' => UploadedFile::fake()->create('backup.zip', 10),
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
});

test('list backups with limited token', function () {
    $token = $this->parseToken(
        $this->admin->createToken('Read Backup Token', [
            Backup::class.':'.Action::Read->value,
        ])
    );

    Backup::factory()->create();
    $response = $this->withToken($token)->withHeader('Accept', 'application/json')->get('/api/backups');

    $response->assertStatus(Response::HTTP_OK);
});

test('show backup with limited token', function () {
    $token = $this->parseToken(
        $this->admin->createToken('Read Backup Token', [
            Backup::class.':'.Action::Read->value,
        ])
    );

    $backup = Backup::factory()->create();
    $response = $this->withToken($token)->withHeader('Accept', 'application/json')->get("/api/backups/{$backup->getKey()}");

    $response->assertStatus(Response::HTTP_OK);
});

test('update backup with limited token', function () {
    $token = $this->parseToken(
        $this->admin->createToken('List Backup Token', [
            Backup::class.':'.Action::Update->value,
        ])
    );

    $backup = Backup::factory()->create();
    $response = $this->withToken($token)->withHeader('Accept', 'application/json')->put("/api/backups/{$backup->getKey()}", [
        'name' => 'Updated Backup',
    ]);

    $response->assertStatus(Response::HTTP_OK);
});

test('remove backup with limited token', function () {
    $token = $this->parseToken(
        $this->admin->createToken('Delete Backup Token', [
            Backup::class.':'.Action::Delete->value,
        ])
    );

    $backup = Backup::factory()->create();
    $response = $this->withToken($token)->withHeader('Accept', 'application/json')->delete("/api/backups/{$backup->getKey()}");

    $response->assertStatus(Response::HTTP_NO_CONTENT);
});
