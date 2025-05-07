<?php

namespace App\Models;

use App\Enums\Action;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'admin',
    ];

    protected function casts(): array
    {
        return [
            'admin' => 'boolean',
        ];
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }

    public function hasPermission(Model|string $resource, Action $action): bool
    {
        // Convert the resource into a class name
        if ($resource instanceof Model) {
            $resource = get_class($resource);
        }

        // Admins have all permissions
        if ($this->admin) {
            return true;
        }

        // Check if we're explicitly granted the request permission
        if ($this->permissions()->whereResource($resource)->whereAction($action)->exists()) {
            return true;
        }

        // Check if we're granted the action for all resources
        if ($this->permissions()->whereResource('*')->whereAction($action)->exists()) {
            return true;
        }

        // Check if we're granted all actions for the resource
        if ($this->permissions()->whereResource($resource)->whereAction('*')->exists()) {
            return true;
        }

        // If none of the above, this role doesn't grant the requested permission
        return false;
    }
}
