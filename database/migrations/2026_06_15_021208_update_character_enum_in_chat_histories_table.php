<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE chat_histories MODIFY COLUMN `character` ENUM('kak-ara', 'kak-reza', 'custom') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE chat_histories MODIFY COLUMN `character` ENUM('kak-ara', 'kak-reza') NOT NULL");
    }
};
