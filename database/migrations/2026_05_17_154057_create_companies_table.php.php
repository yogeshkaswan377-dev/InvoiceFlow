<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('gstin')->unique()->nullable();
            $table->string('pan')->nullable();
            $table->string('cin')->nullable();
            
            // Address fields (Indian format)
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('state_code', 2)->nullable();
            $table->string('pincode', 6)->nullable();
            $table->string('country')->default('India');
            
            // Bank details (JSON)
            $table->json('bank_details')->nullable();
            
            // Logo & Signature paths
            $table->string('logo_path')->nullable();
            $table->string('signature_path')->nullable();
            
            // GST Settings (JSON)
            $table->json('gst_settings')->nullable();
            
            // Invoice Preferences (JSON)
            $table->json('invoice_preferences')->nullable();
            
            // Subscription
            $table->string('subscription_plan')->default('trial');
            $table->timestamp('subscription_expires_at')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for Indian states search
            $table->index('state_code');
            $table->index('gstin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};