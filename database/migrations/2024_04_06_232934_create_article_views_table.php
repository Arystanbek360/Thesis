<?php

use App\Repositories\ClickhouseRepository;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $clickhouse = new ClickhouseRepository();
        $clickhouse->write(
            "CREATE TABLE IF NOT EXISTS article_views
    (
        user_ip String,
        article_id UInt32
    )
    ENGINE = MergeTree()
    ORDER BY article_id;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $clickhouse = new ClickhouseRepository();
        $clickhouse->write('DROP TABLE article_views;');
    }
};
