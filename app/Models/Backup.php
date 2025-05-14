<?php

namespace App\Models;

use App\Observers\BackupObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(BackupObserver::class)]
class Backup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id',
        'disk',
        'filename',
        'type',
        'mime_type',
        'size',
        'meta',
    ];

    protected $casts = [
        'size' => 'integer',
        'meta' => 'json',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function getExtension(): string
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    public function storagePath(): string
    {
        return "backups/{$this->getKey()}.".pathinfo($this->filename, PATHINFO_EXTENSION);
    }
}
