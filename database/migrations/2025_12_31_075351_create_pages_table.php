<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string('title', 191);
            $table->string('slug', 191)->unique();
            $table->longText('content');

            $table->string('meta_title', 191)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('og_image', 255)->nullable();

            $table->boolean('is_active')->default(true)->index();

            // penting: pakai unsignedBigInteger + FK manual (biar bisa kasih nama constraint)
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
        });

        // FK dibuat terpisah + nama constraint unik
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('created_by', 'pages_created_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'pages_updated_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign('pages_created_by_fk');
            $table->dropForeign('pages_updated_by_fk');
        });

        Schema::dropIfExists('pages');
    }
};
