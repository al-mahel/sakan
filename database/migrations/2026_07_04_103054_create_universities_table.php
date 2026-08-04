<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('city')->nullable()->index();

            $table->string('address')->nullable();

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->string('website', 500)->nullable();

            $table->enum('type', [
                'حكومية',
                'أهلية',
                'خاصة',
            ])->default('حكومية')->index();

            $table->string('image')->nullable();

            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true)->index();

            $table->unsignedInteger('order')->default(0);

            $table->timestamps();
        });    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
