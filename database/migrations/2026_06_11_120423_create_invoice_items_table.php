<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable();

            // Item Description
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('hsn_sac_code')->nullable(); // 8-digit HSN/SAC code

            // Quantity & Pricing
            $table->integer('quantity')->default(1);
            $table->string('unit')->default('nos'); // nos, kg, ltr, mtr, etc.
            $table->decimal('unit_price', 15, 2);
            $table->decimal('original_unit_price', 15, 2)->nullable(); // For inclusive mode

            // Discount
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);

            // GST Calculation
            $table->decimal('gst_rate', 5, 2)->default(18.00);
            $table->decimal('taxable_amount', 15, 2)->default(0);
            $table->decimal('cgst_amount', 15, 2)->default(0);
            $table->decimal('sgst_amount', 15, 2)->default(0);
            $table->decimal('igst_amount', 15, 2)->default(0);

            // Totals
            $table->decimal('line_total', 15, 2)->default(0); // Before GST
            $table->decimal('line_total_with_gst', 15, 2)->default(0); // After GST

            // Sorting
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
