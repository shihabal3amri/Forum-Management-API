<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_forum_category_table.php
    public function up()
    {
        Schema::create('forum_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_id')->index();
            $table->foreignId('category_id')->index();
            $table->timestamps();

            // Unique index to prevent duplicate category-forum pairs
            $table->unique(['forum_id', 'category_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_category');
    }
};
