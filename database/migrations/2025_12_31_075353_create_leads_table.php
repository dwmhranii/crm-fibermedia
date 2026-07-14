<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->string('name', 191);
            $table->string('phone', 30)->index();
            $table->string('email', 191)->nullable();
            $table->string('address', 255)->nullable();

            $table->unsignedBigInteger('coverage_id')->nullable()->index();
            $table->unsignedBigInteger('package_id')->nullable()->index();

            $table->text('message')->nullable();
            $table->string('source', 50)->nullable();

            $table->enum('status', ['new', 'contacted', 'closed', 'spam'])->default('new')->index();

            $table->unsignedBigInteger('handled_by')->nullable()->index();
            $table->timestamp('handled_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // FK dibuat terpisah + nama constraint unik
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('coverage_id', 'leads_coverage_fk')
                ->references('id')->on('coverages')
                ->nullOnDelete();

            $table->foreign('package_id', 'leads_package_fk')
                ->references('id')->on('packages')
                ->nullOnDelete();

            $table->foreign('handled_by', 'leads_handled_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign('leads_coverage_fk');
            $table->dropForeign('leads_package_fk');
            $table->dropForeign('leads_handled_by_fk');
        });

        Schema::dropIfExists('leads');
    }
};
