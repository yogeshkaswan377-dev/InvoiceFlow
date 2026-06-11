<?php
// database/migrations/2024_01_01_000002_add_company_settings_fields.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {

            if (!Schema::hasColumn('companies', 'logo_path')) {
                $table->string('logo_path')->nullable();
            }

            if (!Schema::hasColumn('companies', 'signature_path')) {
                $table->string('signature_path')->nullable();
            }

            if (!Schema::hasColumn('companies', 'bank_details')) {
                $table->json('bank_details')->nullable();
            }

            if (!Schema::hasColumn('companies', 'gst_mode_default')) {
                $table->enum('gst_mode_default', ['exclusive', 'inclusive'])
                    ->default('exclusive');
            }

            if (!Schema::hasColumn('companies', 'gst_rates')) {
                $table->json('gst_rates')->nullable();
            }

            if (!Schema::hasColumn('companies', 'invoice_prefix')) {
                $table->string('invoice_prefix')->default('INV-');
            }

            if (!Schema::hasColumn('companies', 'quote_prefix')) {
                $table->string('quote_prefix')->default('QUO-');
            }

            if (!Schema::hasColumn('companies', 'default_payment_terms')) {
                $table->integer('default_payment_terms')->default(15);
            }

            if (!Schema::hasColumn('companies', 'state_code')) {
                $table->string('state_code', 2)->nullable();
            }

            if (!Schema::hasColumn('companies', 'state_name')) {
                $table->string('state_name')->nullable();
            }

            if (!Schema::hasColumn('companies', 'address_line_1')) {
                $table->text('address_line_1')->nullable();
            }

            if (!Schema::hasColumn('companies', 'address_line_2')) {
                $table->text('address_line_2')->nullable();
            }

            if (!Schema::hasColumn('companies', 'city')) {
                $table->string('city')->nullable();
            }

            if (!Schema::hasColumn('companies', 'pincode')) {
                $table->string('pincode', 10)->nullable();
            }

            if (!Schema::hasColumn('companies', 'phone')) {
                $table->string('phone', 20)->nullable();
            }

            if (!Schema::hasColumn('companies', 'website')) {
                $table->string('website')->nullable();
            }

            if (!Schema::hasColumn('companies', 'pan')) {
                $table->string('pan', 10)->nullable();
            }

            if (!Schema::hasColumn('companies', 'cin')) {
                $table->string('cin')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {

            $columns = [
                'logo_path',
                'signature_path',
                'bank_details',
                'gst_mode_default',
                'gst_rates',
                'invoice_prefix',
                'quote_prefix',
                'default_payment_terms',
                'state_code',
                'state_name',
                'address_line_1',
                'address_line_2',
                'city',
                'pincode',
                'phone',
                'website',
                'pan',
                'cin',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('companies', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};