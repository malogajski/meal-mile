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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');;
            $table->foreignId('user_id')->constrained()->onDelete('cascade');;
            $table->string('name');
            $table->decimal('quantity', 15, 2)->default(1);
            $table->decimal('price', 15, 2)->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['team_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
