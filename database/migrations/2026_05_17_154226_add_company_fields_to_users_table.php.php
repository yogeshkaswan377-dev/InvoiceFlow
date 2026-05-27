<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('current_company_id')->nullable()->constrained('companies')->onDelete('set null');
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->json('permissions')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('timezone')->default('Asia/Kolkata');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['current_company_id']);
            $table->dropColumn(['company_id', 'current_company_id', 'phone', 'designation', 'permissions', 'last_login_at', 'timezone']);
        });
    }
};