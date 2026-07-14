<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('album_id')->nullable()->index();

            $table->enum('type', ['image', 'video'])->default('image')->index();
            $table->string('title', 191)->nullable();
            $table->string('caption', 255)->nullable();

            $table->string('file_path', 255)->nullable();
            $table->string('thumb_path', 255)->nullable();
            $table->string('video_url', 255)->nullable();

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();

            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->foreign('album_id', 'gallery_items_album_fk')
                ->references('id')->on('gallery_albums')
                ->nullOnDelete();

            $table->foreign('created_by', 'gallery_items_created_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'gallery_items_updated_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropForeign('gallery_items_album_fk');
            $table->dropForeign('gallery_items_created_by_fk');
            $table->dropForeign('gallery_items_updated_by_fk');
        });

        Schema::dropIfExists('gallery_items');
    }
};
