<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'dosen', 'kajur') NOT NULL DEFAULT 'dosen'");
    }

    public function down(): void
    {
        if (! Schema::hasTable('users') || DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::table('users')
            ->where('role', 'kajur')
            ->update(['role' => 'dosen']);

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'dosen') NOT NULL DEFAULT 'dosen'");
    }
};
