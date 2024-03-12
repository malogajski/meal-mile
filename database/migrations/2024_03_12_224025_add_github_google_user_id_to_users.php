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
            $table->string('password')->nullable()->change();

            $table->string('github_refresh_token')->after('password')->nullable();
            $table->string('github_token')->after('password')->nullable();
            $table->string('github_id')->after('password')->nullable();

            $table->string('google_refresh_token')->after('password')->nullable();
            $table->string('google_token')->after('password')->nullable();
            $table->string('google_id')->after('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
