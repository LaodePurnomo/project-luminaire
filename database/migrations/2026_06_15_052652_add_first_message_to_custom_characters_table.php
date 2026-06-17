<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('custom_characters', function (Blueprint $table) {
            $table->text('first_message')->nullable()->after('personality');
        });
    }

    public function down(): void
    {
        Schema::table('custom_characters', function (Blueprint $table) {
            $table->dropColumn('first_message');
        });
    }
};
