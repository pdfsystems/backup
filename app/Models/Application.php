<?php

namespace App\Models;

use Dyrynda\Database\Support\NullableFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, NullableFields, SoftDeletes;

    protected $fillable = [
        'name',
        'url',
    ];

    protected array $nullable = [
        'url',
    ];

    public function backups(): HasMany
    {
        return $this->hasMany(Backup::class);
    }
}
