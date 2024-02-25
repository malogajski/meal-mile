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
        Schema::create('shopping_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('shopping_list_id')->constrained();
            $table->foreignId('item_id');
            $table->boolean('is_purchased')->default(false);
            $table->foreignId('added_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('purchased_by_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->decimal('quantity', 15,2)->default(1);
            $table->decimal('price', 15, 2)->default(1);
            $table->decimal('total_price', 10, 2)->storedAs('quantity * price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_list_items');
    }
};
