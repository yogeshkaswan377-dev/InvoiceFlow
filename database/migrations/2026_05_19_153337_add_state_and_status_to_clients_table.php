<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('clients', 'state')) {
                $table->string('state')->nullable()->after('city');
            }
            if (!Schema::hasColumn('clients', 'status')) {
                $table->string('status')->default('active')->after('is_active');
            }
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['state', 'status']);
        });
    }
};