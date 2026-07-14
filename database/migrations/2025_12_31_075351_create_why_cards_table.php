<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('why_cards', function (Blueprint $table) {
            $table->id();

            $table->string('title', 150);
            $table->string('subtitle', 200)->nullable();
            $table->text('description');

            $table->string('icon', 50)->nullable();
            $table->string('bg_color', 20)->nullable();
            $table->string('text_color', 20)->nullable();

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_cards');
    }
};
