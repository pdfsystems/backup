<?php

use App\Models\Application;
use App\Models\Backup;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

test('create backups', function () {
    $application = Application::factory()->create();

    $response = $this->withToken($this->adminToken)->withHeader('Accept', 'application/json')->post('/api/backups', [
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
    expect($response->json('filename'))->toBe('backup.zip')
        ->and($response->json('id'))->toBeGreaterThan(0)
        ->and($response->json('size'))->toBe(10240);
});

test('list backups', function () {
    Backup::factory()->count(10)->create();
    $response = $this->withToken($this->adminToken)->withHeader('Accept', 'application/json')->get('/api/backups');

    $response->assertStatus(Response::HTTP_OK);
    expect($response->json('total'))->toBe(10)
        ->and($response->json('data'))->toHaveCount(10);
});

test('show backup', function () {
    $backup = Backup::factory()->create();
    $response = $this->withToken($this->adminToken)->withHeader('Accept', 'application/json')->get("/api/backups/{$backup->getKey()}");

    $response->assertStatus(Response::HTTP_OK);
    expect($response->json('id'))->toBe($backup->getKey())
        ->and($response->json('name'))->toBe($backup->name);
});

test('update backup', function () {
    $backup = Backup::factory()->create();
    $response = $this->withToken($this->adminToken)->withHeader('Accept', 'application/json')->put("/api/backups/{$backup->getKey()}", [
        'meta' => [
            'foo' => 'bar',
        ],
    ]);

    $response->assertStatus(Response::HTTP_OK);
    expect($response->json('id'))->toBe($backup->getKey())
        ->and($response->json('meta.foo'))->toBe('bar')
        ->and($response->json('size'))->toBe($backup->size);
});

test('remove backup', function () {
    $backup = Backup::factory()->create();
    $response = $this->withToken($this->adminToken)->withHeader('Accept', 'application/json')->delete("/api/backups/{$backup->getKey()}");

    $response->assertStatus(Response::HTTP_NO_CONTENT);
    expect($response->isEmpty())->toBeTrue()
        ->and(Backup::count())->toBe(0);
});

test('show missing backup', function () {
    $response = $this->withToken($this->adminToken)->withHeader('Accept', 'application/json')->get('/api/backups/1');
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});
