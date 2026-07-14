<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            $table->string('title', 191)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->text('description')->nullable();

            $table->string('image_desktop', 255);
            $table->string('image_mobile', 255)->nullable();

            $table->string('cta_text', 50)->nullable();
            $table->string('cta_url', 255)->nullable();

            $table->boolean('open_in_new_tab')->default(false);

            $table->enum('position', ['home_hero','home_mid','home_bottom'])->default('home_hero')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->boolean('is_active')->default(true)->index();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['start_at', 'end_at'], 'banners_active_period_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
