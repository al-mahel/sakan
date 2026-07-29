<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->enum('type', ['حكومية', 'أهلية', 'خاصة'])->default('حكومية')->after('description');
            $table->string('website')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn(['type', 'website']);
        });
    }
};
