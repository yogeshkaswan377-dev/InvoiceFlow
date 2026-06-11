<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('gst_invoice'); // proforma, gst_invoice
            $table->boolean('is_default')->default(false);

            // Template Configuration
            $table->string('color_scheme')->default('#4F46E5'); // Primary color
            $table->string('font_family')->default('Inter');
            $table->boolean('show_logo')->default(true);
            $table->boolean('show_signature')->default(false);
            $table->boolean('show_upi_qr')->default(false);

            // Content
            $table->text('header_text')->nullable();
            $table->text('footer_text')->nullable();
            $table->text('terms_and_conditions')->nullable();

            // Layout
            $table->json('layout_config')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_templates');
    }
};
