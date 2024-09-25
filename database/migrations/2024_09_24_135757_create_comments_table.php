<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_comments_table.php
    public function up()
    {
        // Create the parent comments table with partitioning
        DB::statement('
        CREATE TABLE comments (
            id BIGSERIAL,
            post_id BIGINT NOT NULL,
            user_id BIGINT NOT NULL,
            content TEXT,
            created_at TIMESTAMPTZ NOT NULL,
            updated_at TIMESTAMPTZ,
            PRIMARY KEY (id, created_at),  -- Primary key now includes both id and created_at
            FOREIGN KEY (post_id, created_at) REFERENCES posts(id, created_at),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) PARTITION BY RANGE (created_at);
    ');

        // Create child partitions for the first three years
        DB::statement("
        CREATE TABLE comments_2024 PARTITION OF comments
        FOR VALUES FROM ('2024-01-01') TO ('2025-01-01');
    ");
        DB::statement("
        CREATE TABLE comments_2025 PARTITION OF comments
        FOR VALUES FROM ('2025-01-01') TO ('2026-01-01');
    ");
        DB::statement("
        CREATE TABLE comments_2026 PARTITION OF comments
        FOR VALUES FROM ('2026-01-01') TO ('2027-01-01');
    ");

        // Add indexes on the parent table
        DB::statement("
        CREATE INDEX comments_post_id_index ON comments (post_id);
    ");
        DB::statement("
        CREATE INDEX comments_user_id_index ON comments (user_id);
    ");

        DB::statement("
        CREATE INDEX comments_fulltext_index ON comments USING GIN (to_tsvector('english', content));
    ");
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
