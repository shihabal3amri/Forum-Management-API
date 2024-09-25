<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_posts_table.php
    public function up()
    {
        // Create the parent posts table with partitioning
        DB::statement('
        CREATE TABLE posts (
            id BIGSERIAL,
            category_id BIGINT NOT NULL,
            user_id BIGINT NOT NULL,
            content TEXT,
            forum_id BIGINT NOT NULL,
            created_at TIMESTAMPTZ NOT NULL,
            updated_at TIMESTAMPTZ,
            PRIMARY KEY (id, created_at),  -- Primary key now includes both id and created_at
            FOREIGN KEY (category_id) REFERENCES categories(id),
            FOREIGN KEY (forum_id) REFERENCES forums(id),
            FOREIGN KEY (user_id) REFERENCES users(id)
        ) PARTITION BY RANGE (created_at);
    ');

        // Create child partitions for the first three years
        DB::statement("
        CREATE TABLE posts_2024 PARTITION OF posts
        FOR VALUES FROM ('2024-01-01') TO ('2025-01-01');
    ");
        DB::statement("
        CREATE TABLE posts_2025 PARTITION OF posts
        FOR VALUES FROM ('2025-01-01') TO ('2026-01-01');
    ");
        DB::statement("
        CREATE TABLE posts_2026 PARTITION OF posts
        FOR VALUES FROM ('2026-01-01') TO ('2027-01-01');
    ");

        // Add indexes on the parent table
        DB::statement("
        CREATE INDEX posts_forum_id_index ON posts (forum_id);
    ");
        DB::statement("
        CREATE INDEX posts_user_id_index ON posts (user_id);
    ");
        DB::statement("
        CREATE INDEX posts_category_id_index ON posts (category_id);
    ");
        DB::statement("
        CREATE INDEX posts_fulltext_index ON posts USING GIN (to_tsvector('english', content));
    ");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
