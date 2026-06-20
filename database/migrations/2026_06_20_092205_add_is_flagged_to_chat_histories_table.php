<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::table('chat_histories', function (Blueprint $table) {
            $table->boolean('is_flagged')->default(false)->nullable(false);
            $table->string('flag_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('chat_histories', function (Blueprint $table) {
            $table->dropColumn('is_flagged');
            $table->dropColumn('flag_reason');
        });
    }
};


// still hardcoded but its all fine :)
// not really I lied, more stress.
// my hair is turning WHITE and I'm not even over 20 yet T-T