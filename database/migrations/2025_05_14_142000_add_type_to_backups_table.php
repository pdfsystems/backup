<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('backups', function (Blueprint $table) {
            $table->string('type')->after('filename')->nullable();

            $table->index([
                'application_id',
                'type',
                'created_at',
            ]);
        });
    }

    public function down(): void
    {
        /*
         * It seems MySQL/MariaDB creates an implicit index for foreign keys, which gets dropped when an explicit
         * index with the same first column is created. So, to roll back that explicit index, we first need to
         * explicitly re-create the previously implicitly created index.
         */
        try {
            Schema::table('backups', function (Blueprint $table) {
                $table->index('application_id');
            });
        } catch (QueryException) {
        }

        Schema::table('backups', function (Blueprint $table) {
            $table->dropIndex([
                'application_id',
                'type',
                'created_at',
            ]);

            $table->dropColumn('type');
        });
    }
};
