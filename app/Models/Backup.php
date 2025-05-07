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
        'mime_type',
        'size',
        'meta',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    protected function casts(): array
    {
        return [
            'size' => 'int',
            'meta' => 'json',
        ];
    }
}
