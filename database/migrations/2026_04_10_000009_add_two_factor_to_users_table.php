<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'two_factor_enabled')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->boolean('two_factor_enabled')->default(true)->after('locked_until');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'two_factor_enabled')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('two_factor_enabled');
            });
        }
    }
};
