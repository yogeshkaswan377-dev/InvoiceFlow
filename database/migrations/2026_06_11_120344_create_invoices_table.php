<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            // Invoice Identification
            $table->string('invoice_number')->unique();
            $table->string('invoice_type')->default('gst_invoice'); // proforma, gst_invoice
            $table->enum('status', [
                'draft',
                'sent',
                'viewed',
                'accepted',
                'paid',
                'partially_paid',
                'overdue',
                'cancelled'
            ])->default('draft');
            $table->string('reference_number')->nullable(); // Your PO number
            $table->string('irn')->nullable(); // Invoice Reference Number (e-invoicing)

            // Dates
            $table->date('invoice_date');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->date('cancelled_date')->nullable();

            // GST Configuration
            $table->enum('gst_mode', ['exclusive', 'inclusive'])->default('exclusive');
            $table->decimal('gst_rate', 5, 2)->default(18.00);
            $table->string('place_of_supply')->nullable();
            $table->string('place_of_supply_state_code')->nullable();
            $table->boolean('reverse_charge')->default(false);

            // Financial Fields
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('taxable_amount', 15, 2)->default(0);
            $table->decimal('cgst_amount', 15, 2)->default(0);
            $table->decimal('sgst_amount', 15, 2)->default(0);
            $table->decimal('igst_amount', 15, 2)->default(0);
            $table->decimal('total_gst_amount', 15, 2)->default(0);
            $table->decimal('shipping_charges', 15, 2)->default(0);
            $table->decimal('commission', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('balance_due', 15, 2)->default(0);

            // Additional Info
            $table->text('notes')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->string('payment_terms')->default('Net 15');
            $table->json('logistics_details')->nullable();
            $table->date('estimated_delivery_date')->nullable();

            // Display & Template
            $table->unsignedBigInteger('template_id')->nullable();
            $table->boolean('show_hsn_sac')->default(true);
            $table->boolean('show_digital_signature')->default(false);

            // Meta & Audit
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['company_id', 'status']);
            $table->index(['client_id']);
            $table->index(['invoice_date']);
            $table->index(['due_date']);
            $table->index(['invoice_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
