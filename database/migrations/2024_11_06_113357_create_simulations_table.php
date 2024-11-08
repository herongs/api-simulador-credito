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
        Schema::create('simulations', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->decimal('loan_amount', 15, 2);
            $table->integer('payment_date');
            $table->date('birth_date');
            $table->decimal('interest_rate', 5, 2);
            $table->enum('interest_type', ['FIXA', 'VARIAVEL']);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('total_payment', 15, 2);
            $table->decimal('monthly_payment', 15, 2);
            $table->decimal('total_interest', 15, 2);
            $table->string('currency', 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulations');
    }
};
