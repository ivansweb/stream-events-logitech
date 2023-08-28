<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id')
                ->nullable()
                ->after('remember_token')
                ->comment('Social ID (Google, Facebook, etc.)');
            $table->string('social_type')
                ->nullable()
                ->after('social_id')
                ->comment('Social Type (Google, Facebook, etc.)');
            $table->timestamp('last_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('social_id');
            $table->dropColumn('social_type');
            $table->dropColumn('last_login');
        });
    }
};
