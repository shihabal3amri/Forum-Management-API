<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_private_messages_table.php
    public function up()
    {
        // Create the parent private_messages table with partitioning
        DB::statement('
        CREATE TABLE private_messages (
            id BIGSERIAL,
            sender_id BIGINT NOT NULL,
            receiver_id BIGINT NOT NULL,
            message TEXT,
            created_at TIMESTAMPTZ NOT NULL,
            updated_at TIMESTAMPTZ,
            PRIMARY KEY (id, created_at),  -- Primary key now includes both id and created_at
            FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
        ) PARTITION BY RANGE (created_at);
    ');

        // Create child partitions for the first three years
        DB::statement("
        CREATE TABLE private_messages_2024 PARTITION OF private_messages
        FOR VALUES FROM ('2024-01-01') TO ('2025-01-01');
    ");
        DB::statement("
        CREATE TABLE private_messages_2025 PARTITION OF private_messages
        FOR VALUES FROM ('2025-01-01') TO ('2026-01-01');
    ");
        DB::statement("
        CREATE TABLE private_messages_2026 PARTITION OF private_messages
        FOR VALUES FROM ('2026-01-01') TO ('2027-01-01');
    ");

        // Add indexes on the parent table
        DB::statement("
        CREATE INDEX private_messages_sender_id_index ON private_messages (sender_id);
    ");
        DB::statement("
        CREATE INDEX private_messages_receiver_id_index ON private_messages (receiver_id);
    ");

        DB::statement("
        CREATE INDEX private_messages_created_at_index ON private_messages (created_at);
    ");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_messages');
    }
};
