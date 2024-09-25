<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateNewPartitions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partitions:create {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new partitions for posts, comments, and private messaging tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the year to create partitions for
        $year = $this->argument('year') ?? now()->year;

        // Create partitions for posts, comments, and private messages
        $this->createPartitionForTable('posts', $year);
        $this->createPartitionForTable('comments', $year);
        $this->createPartitionForTable('private_messages', $year);

        $this->info("Partitions for year {$year} created successfully.");
    }

    /**
     * Create partitions for the given table and year.
     *
     * @param string $table
     * @param int $year
     */
    protected function createPartitionForTable($table, $year)
    {
        // Define the partition boundaries
        $startDate = "{$year}-01-01";
        $endDate = ($year + 1) . "-01-01";

        // Build partition table names
        $partitionTableName = "{$table}_{$year}";

        // SQL to create partition
        $sql = "
            CREATE TABLE IF NOT EXISTS {$partitionTableName} PARTITION OF {$table}
            FOR VALUES FROM ('{$startDate}') TO ('{$endDate}');
        ";

        // Execute the SQL
        DB::statement($sql);

        $this->info("Partition created for table {$table}: {$partitionTableName}");
    }
}
