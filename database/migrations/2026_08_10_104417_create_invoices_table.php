<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->date('invoice_date')->nullable();
            $table->date('due_date');
            $table->string('product');
            $table->decimal('amount_collection', 10, 2);
            $table->decimal('amount_commission', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->string('rate_vat');
            $table->decimal('value_vat', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('status');
            $table->string('value_status');
            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();
            $table->string('user');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
