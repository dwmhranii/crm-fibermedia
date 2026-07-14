<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah setelah id (optional)
            $table->unsignedBigInteger('role_id')->after('id')->nullable();

            $table->string('phone', 30)->nullable()->after('password');
            $table->boolean('is_active')->default(true)->after('phone');
            $table->timestamp('last_login_at')->nullable()->after('is_active');

            $table->softDeletes();

            $table->index('role_id');
            // FK ke roles, SET NULL biar aman kalau role dihapus
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // drop FK dulu
            $table->dropForeign(['role_id']);
            $table->dropIndex(['role_id']);

            $table->dropColumn(['role_id', 'phone', 'is_active', 'last_login_at']);
            $table->dropSoftDeletes();
        });
    }
};
