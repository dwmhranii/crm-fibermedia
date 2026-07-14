<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('slug', 150)->unique();

            $table->enum('type', ['home', 'business'])->default('home')->index();
            $table->enum('category', ['internet_only','internet_tv','streaming','kuota_hp'])->nullable()->index();

            $table->boolean('includes_tv')->default(false);
            $table->boolean('includes_streaming_app')->default(false);
            $table->boolean('includes_mobile_quota')->default(false);

            $table->boolean('good_for_gaming')->default(false);
            $table->boolean('good_for_streaming')->default(false);
            $table->boolean('good_for_wfh')->default(false);

            $table->unsignedTinyInteger('min_users')->nullable();
            $table->unsignedTinyInteger('max_users')->nullable();

            $table->string('best_for', 191)->nullable();

            $table->unsignedInteger('speed_mbps');
            $table->unsignedInteger('price_monthly');

            $table->string('device_ideal', 100)->nullable();
            $table->unsignedTinyInteger('duration_months')->default(1);

            $table->text('features')->nullable();
            $table->string('whatsapp_order_url', 255)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->string('short_description', 255)->nullable();

            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_best_seller')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
