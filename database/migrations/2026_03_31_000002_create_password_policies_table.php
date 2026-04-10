<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('password_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('min_length')->default(12);
            $table->boolean('require_uppercase')->default(true);
            $table->boolean('require_lowercase')->default(true);
            $table->boolean('require_numeric')->default(true);
            $table->boolean('require_symbol')->default(true);
            $table->unsignedTinyInteger('history_depth')->default(5);
            $table->unsignedSmallInteger('expiry_days')->default(90);
            $table->unsignedTinyInteger('lockout_threshold')->default(5);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_policies');
    }
};
