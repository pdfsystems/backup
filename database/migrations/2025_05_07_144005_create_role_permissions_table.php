<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Role::class)->constrained('roles')->cascadeOnDelete();
            $table->string('resource');
            $table->string('action');

            $table->unique([
                'resource',
                'action',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
